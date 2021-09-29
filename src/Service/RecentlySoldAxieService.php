<?php
/**
 * RecentlySoldAxieService.php file summary.
 *
 * RecentlySoldAxieService.php file description.
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

use App\Entity\Axie;
use App\Entity\RecentlySoldAxie;
use App\Repository\AxieRepository;
use App\Repository\RecentlySoldAxieRepository;
use Doctrine\ORM\EntityManagerInterface;
use ProxyManager\Exception\ExceptionInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class RecentlySoldAxieService.
 *
 * Class RecentlySoldAxieService description.
 *
 * @since 1.0.0
 */
class RecentlySoldAxieService
{

    /**
     * @var RecentlySoldAxieRepository
     */
    private $recentlySoldAxieRepo;
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var SymfonyStyle|null
     */
    private $io;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var AxieFactoryService
     */
    private $axieFactoryService;
    /**
     * @var AxieDataService
     */
    private $axieDataService;

    public function __construct(RecentlySoldAxieRepository $recentlySoldAxieRepo, AxieRepository $axieRepo, EntityManagerInterface $em, AxieFactoryService $axieFactoryService, AxieDataService $axieDataService)
    {
        $this->recentlySoldAxieRepo = $recentlySoldAxieRepo;
        $this->axieRepo = $axieRepo;
        $this->em = $em;
        $this->axieFactoryService = $axieFactoryService;
        $this->axieDataService = $axieDataService;
    }

    public function getMinUsdPrice() {
        return 480;
    }

    private function log($msg, $type = 'note') : void {
        if ($this->io === null) {
            return;
        }
        $this->io->{$type}($msg);
    }

    public function crawl(SymfonyStyle $io = null) {
        $this->io = $io;
        $output = [];
        $newAxies = [];
        $qualifiedRecentlySold = 0;

        $client = HttpClient::create();
        $jsonPayload = '{"operationName":"GetRecentlyAxiesSold","variables":{"from":0,"size":100,"sort":"Latest","auctionType":"Sale"},"query":"query GetRecentlyAxiesSold($from: Int, $size: Int) {\n  settledAuctions {\n    axies(from: $from, size: $size) {\n      total\n      results {\n        ...AxieSettledBrief\n        transferHistory {\n          ...TransferHistoryInSettledAuction\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment AxieSettledBrief on Axie {\n  id\n  name\n  image\n  class\n  breedCount\n  __typename\n}\n\nfragment TransferHistoryInSettledAuction on TransferRecords {\n  total\n  results {\n    ...TransferRecordInSettledAuction\n    __typename\n  }\n  __typename\n}\n\nfragment TransferRecordInSettledAuction on TransferRecord {\n  from\n  to\n  txHash\n  timestamp\n  withPrice\n  withPriceUsd\n  fromProfile {\n    name\n    __typename\n  }\n  toProfile {\n    name\n    __typename\n  }\n  __typename\n}\n"}';

        $fetchPayload = [
            'url' => 'https://graphql-gateway.axieinfinity.com/graphql',
            'payload' => [
                'json' => json_decode($jsonPayload)
            ],
        ];
        $response = $client->request('POST', $fetchPayload['url'], $fetchPayload['payload']);

        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            $this->log('> error: cannot even get the status code.', 'error');
            return $output;
        }

        if (200 !== $statusCode) {
            $this->log('> error: expecting 200 status code, got ' . $statusCode . ' instead.', 'error');
            return $output;
        }

        $content = $response->toArray();

        if (empty($content['data']['settledAuctions']['axies']['results'])) {
            $this->log('> error: malformed or empty response.', 'error');
            return $output;
        }

        $axieResults = $content['data']['settledAuctions']['axies']['results'];
        $this->log(count($content['data']['settledAuctions']['axies']['results']) . ' axies recently sold');

        foreach($axieResults as $axieResult) {
            if (empty($axieResult['id'])) {
                $this->log('> error: an axie has no ID???', 'error');
                continue;
            }
            if (!isset($axieResult['transferHistory']['results'][0]['withPrice'], $axieResult['transferHistory']['results'][0]['withPriceUsd'])) {
                $this->log('> error: axie: ' . $axieResult['id'] . ' has missing fields.', 'error');
                continue;
            }

            // check price if passed.
            if ( $this->getMinUsdPrice() > $axieResult['transferHistory']['results'][0]['withPriceUsd'] ) {
                $this->log('axie: ' . $axieResult['id'] . ' only costs ' . $axieResult['transferHistory']['results'][0]['withPriceUsd']);
                continue;
            }
            $createOrGet = $this->axieFactoryService->createOrGetEntity($axieResult);

            if ( true === $createOrGet['$isAdded'] ) {
                $newAxies[] = $axieResult['id'];
            }

            $axieEntity = $createOrGet['$axieEntity'];

            // check if this axie has been sold at the same price already for the last hour
            $ethDivisor = 1000000000000000000;
            $ethPrice = (float) $axieResult['transferHistory']['results'][0]['withPrice'] / $ethDivisor;
            $now = new \DateTime('now', new \DateTimeZone('UTC'));
            $ago = $now->modify('-1 hour');

            if ( !empty($axieResult['transferHistory']['results'][0]['timestamp']) ) {
                $dateSold = \DateTime::createFromFormat('U', (string) $axieResult['transferHistory']['results'][0]['timestamp']);
            } else {
                $dateSold = $now;
            }

            $hasBeenSoldRecently = $this->recentlySoldAxieRepo->hasBeenSoldBetween($axieEntity, $ethPrice, $dateSold, $ago );

            if (true === $hasBeenSoldRecently) {
                $this->log('axie: ' . $axieResult['id'] . ' has been sold already recently at the same price ' . $ethPrice);
                continue;
            }
            $qualifiedRecentlySold++;
            $recentlySold = new RecentlySoldAxie();
            $recentlySold
                ->setDate($dateSold)
                ->setAxie($axieEntity)
                ->setPriceUsd((float) $axieResult['transferHistory']['results'][0]['withPriceUsd'])
                ->setPriceEth($ethPrice)
            ;

            $this->em->persist($recentlySold);
            $this->em->flush();

        }

        if (!empty($newAxies)) {
            $this->axieDataService->processAllUnprocessed($this->io, $newAxies);
        }

        $this->log('there are ' . $qualifiedRecentlySold . ' qualified recently sold and ' . count($newAxies) . ' of them are new axies added to the DB');

        return $output;
    }

}
