<?php
/**
 * MarketplaceOverviewService.php file summary.
 *
 * MarketplaceOverviewService.php file description.
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

use App\Entity\MarketplaceOverview;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class MarketplaceOverviewService.
 *
 * Class MarketplaceOverviewService description.
 *
 * @since 1.0.0
 */
class MarketplaceOverviewService
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SymfonyStyle|null
     */
    private $io;
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(EntityManagerInterface $em, HttpClientInterface $httpClient) {

        $this->em = $em;
        $this->httpClient = $httpClient;
    }

    private function log($msg, $type = 'note') : void {
        if ($this->io === null) {
            return;
        }
        $this->io->{$type}($msg);
    }

    public function fetch(SymfonyStyle $io = null) {
        $this->io = $io;
        $jsonPayload =  '{"operationName":"GetOverviewToday","variables":{},"query":"query GetOverviewToday {\n  marketStats {\n    last24Hours {\n      ...OverviewFragment\n      __typename\n    }\n    last7Days {\n      ...OverviewFragment\n      __typename\n    }\n    last30Days {\n      ...OverviewFragment\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment OverviewFragment on SettlementStats {\n  count\n  axieCount\n  volume\n  volumeUsd\n  __typename\n}\n"}';

        $response = $this->httpClient->request('POST', 'https://graphql-gateway.axieinfinity.com/graphql', ['json' => json_decode($jsonPayload)]);

        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            $this->log('> error: cannot even get the status code.', 'error');
            return;
        }

        if (200 !== $statusCode) {
            $this->log('> error: expecting 200 status code, got ' . $statusCode . ' instead.', 'error');
            return;
        }

        $content = $response->toArray();

        if (!isset($content['data']['marketStats'])) {
            $this->log('> error: malformed API response.', 'error');
            return;
        }

        $content = $content['data']['marketStats'];

        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $ethDivisor = 1000000000000000000;

        foreach(['last24Hours', 'last7Days', 'last30Days' ] as $spanType) {
            if (!empty($content[$spanType])) {

                $node = $content[$spanType];

                $marketOverview = new MarketplaceOverview();
                $marketOverview
                    ->setDate($now)
                    ->setSpan($spanType)
                    ->setAxieSold( $node['axieCount'] ?? null )
                    ->setTotalSold( $node['count'] ?? null )
                    ->setVolumeEth( $node['volume'] ? $node['volume'] / $ethDivisor : null )
                    ->setVolumeUsd( $node['volumeUsd'] ?? $node['volumeUsd'] )
                ;
                $this->em->persist($marketOverview);

            }
        }

        $this->em->flush();

    }

}
