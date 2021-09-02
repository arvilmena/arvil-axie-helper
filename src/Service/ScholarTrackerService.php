<?php
/**
 * ScholarTrackerService.php file summary.
 *
 * ScholarTrackerService.php file description.
 *
 * @link       https://project.com
 *
 * @package    Project
 *
 * @subpackage App\Service
 *
 * @author     Arvil Meña <arvil@arvilmena.com>
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Scholar;
use App\Entity\ScholarHistory;
use App\Repository\ScholarRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class ScholarTrackerService.
 *
 * Class ScholarTrackerService description.
 *
 * @since 1.0.0
 */
class ScholarTrackerService
{

    /**
     * @var ScholarRepository
     */
    private $scholarRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ScholarRepository $scholarRepo, EntityManagerInterface $em) {

        $this->scholarRepo = $scholarRepo;
        $this->em = $em;
    }

    public function saveAllScholarDataNow() {

        $client = HttpClient::create();

        $scholars = $this->scholarRepo->findAll();
        $responses = [];

        foreach ($scholars as $scholar ) {
            $uri = "https://api.lunaciarover.com/stats/0x" . trim($scholar->getRoninAddress(), 'ronin:');

            $responses[] = $client->request('GET', $uri, [
                'user_data' => [
                    'scholar_id' => $scholar->getId()
                ],
            ]);
        }

        /**
         * @var $response ResponseInterface
         */
        foreach ($client->stream($responses) as $response => $chunk) {
            try {
                if ($chunk->isTimeout()) {
                    // ... decide what to do when a timeout occurs
                    // if you want to stop a response that timed out, don't miss
                    // calling $response->cancel() or the destructor of the response
                    // will try to complete it one more time
                    $response->cancel();
                } elseif ($chunk->isFirst()) {
                } elseif ($chunk->isLast()) {
                    if ( 200 !== $response->getStatusCode() ) {
                        continue;
                    }

                    $result = $response->toArray();

                    $scholar = $this->scholarRepo->find( $response->getInfo('user_data')['scholar_id'] );

                    $history = new ScholarHistory( new \DateTime('now') );
                    $history
                        ->setScholar($scholar)
                        ->setGameSlp( $result['in_game_slp'] )
                        ->setTotalSlp( $result['total_slp'] )
                        ->setRoninSlp( $result['ronin_slp'] )
                        ->setLastClaim( (new \DateTime())->setTimestamp( $result['last_claim_timestamp'] )->setTimezone(new \DateTimeZone('UTC')) )
                        ->setElo( $result['mmr'] )
                        ->setRank( $result['rank'] )
                    ;

                    $this->em->persist($history);
                    $this->em->flush();
                }
            } catch (TransportExceptionInterface $e) {
                // ...
            }
        }




    }

}
