<?php
/**
 * CrawlMarketplaceWatchlistService.php file summary.
 *
 * CrawlMarketplaceWatchlistService.php file description.
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
use App\Entity\AxieRawData;
use App\Entity\CrawlAxieResult;
use App\Entity\MarketplaceCrawl;
use App\Repository\AxieRawDataRepository;
use App\Repository\AxieRepository;
use App\Repository\MarketplaceWatchlistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Uid\Ulid;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class CrawlMarketplaceWatchlistService.
 *
 * Class CrawlMarketplaceWatchlistService description.
 *
 * @since 1.0.0
 */
class CrawlMarketplaceWatchlistService
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var MarketplaceWatchlistRepository
     */
    private $watchlistRepo;

    const NUMBER_OF_RESULTS = 14;
    const NUMBER_OF_RESULTS_FOR_PAGINATED = 30;
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var AxieRawDataRepository
     */
    private $axieRawDataRepo;

    private $io;

    public function __construct(
        EntityManagerInterface $em,
        MarketplaceWatchlistRepository $watchlistRepo,
        AxieRepository $axieRepo,
        AxieRawDataRepository $axieRawDataRepo
    )
    {
        $this->em = $em;
        $this->watchlistRepo = $watchlistRepo;
        $this->axieRepo = $axieRepo;
        $this->axieRawDataRepo = $axieRawDataRepo;
    }

    public function log($msg, $type = 'note') {
        if ($this->io !== null) {
            $this->io->{$type}($msg);
        }
    }

    public function processResponse($crawlSessionUlid, $response, $output = [], SymfonyStyle $io = null) {

        if (null !== $io && $this->io === null) {
            $this->io = $io;
        }

        $crawl = new MarketplaceCrawl($response->getInfo('user_data')['request'], new \DateTime('now', new \DateTimeZone('UTC')));
        $crawl
            ->setCrawlSessionUlid($crawlSessionUlid);

        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            $this->em->persist($crawl);
            return $output;
        }

        $crawl->setStatusCode($statusCode);

        if ($statusCode !== 200) {
            $this->em->persist($crawl);
            return $output;
        }

        $content = $response->toArray();

        $watchlist = $this->watchlistRepo->find((int) $response->getInfo('user_data')['watchlistId']);
        $crawl
            ->setResponse(json_encode($content))
            ->setMarketplaceWatchlist($watchlist)
        ;

        if ( ! empty($content['errors']) || empty($content['data']['axies']) || 1 > (int) $content['data']['axies']['total']) {
            $crawl->setIsValid(false);
        } else {
            $crawl->setIsValid(true);

            $lowestPriceEth = PHP_INT_MAX;
            $highestPriceEth = 0;
            $lowestPriceUsd = PHP_INT_MAX;
            $highestPriceUsd = 0;
            $sumEth = 0;
            $sumUsd = 0;
            $totalAxieResult = sizeof($content['data']['axies']['results']);
            $count = 0;
            $summedForAverage = 0;
            $prices = [];
            foreach($content['data']['axies']['results'] as $axie) {
                $axieEntity = $this->axieRepo->find((int) $axie['id']);
                if (null === $axieEntity) {
                    $axieEntity = new Axie((int) $axie['id']);
                }
                if (empty($axieEntity->getImageUrl()) && ! empty($axie['image'])) {
                    $axieEntity->setImageUrl(trim($axie['image']));
                }

                $output['axiesAdded'][] = (int) $axie['id'];

                $rawDataEntity = $this->axieRawDataRepo->find($axieEntity->getId());
                if (null === $rawDataEntity) {
                    $rawDataEntity = new AxieRawData($axieEntity);
                }
                $rawDataEntity->setRawDataBrief(json_encode($axie));
                $this->em->persist($rawDataEntity);
                $this->em->flush();

                $axieResult = new CrawlAxieResult();
                $axieResult
                    ->setCrawl($crawl)
                    ->setAxie($axieEntity);

                if (isset($axie['breedCount'])) {
                    $axieResult->setBreedCount((int) $axie['breedCount']);
                }


                // should not be banned.
                if ( false !== $axie['battleInfo']['banned'] ) {
                    continue;
                }

                if (
                    !isset($axie['auction']['__typename'])
                    || ('Auction' !== $axie['auction']['__typename'])
                    || (empty($axie['auction']['currentPrice']) && 0 !== $axie['auction']['currentPrice'])
                    || (empty($axie['auction']['currentPriceUSD']) && 0 !== $axie['auction']['currentPriceUSD'])
                ) {
                    continue;
                }

                $axieResult
                    ->setPriceEth(round($axie['auction']['currentPrice'] / 100000000000000000, 4))
                    ->setPriceUsd((float) $axie['auction']['currentPriceUSD']);

                if ( $axieEntity->getAvgAttackPerCard() > 0 && $axieEntity->getAvgDefencePerCard() > 0 ) {
                    $axieEntity
                        ->setAttackPerUsd( $axieEntity->getAvgAttackPerCard() / (float) $axie['auction']['currentPriceUSD'] )
                        ->setDefencePerUsd( $axieEntity->getAvgDefencePerCard() / (float) $axie['auction']['currentPriceUSD'] )
                    ;
                    $this->em->persist($axieEntity);
                    $this->em->flush();
                }

                if ($axie['auction']['currentPrice'] < $lowestPriceEth) {
                    $lowestPriceEth = $axie['auction']['currentPrice'] / 100000000000000000;
                }
                if ($axie['auction']['currentPrice'] > $highestPriceEth) {
                    $highestPriceEth = $axie['auction']['currentPrice'] / 100000000000000000;
                }
                if ($axie['auction']['currentPriceUSD'] < $lowestPriceUsd) {
                    $lowestPriceUsd = (float) $axie['auction']['currentPriceUSD'];
                }
                if ($axie['auction']['currentPriceUSD'] > $highestPriceUsd) {
                    $highestPriceUsd = (float) $axie['auction']['currentPriceUSD'];
                }
                // Don't include the first one, they can be noise sometimes
                if ($count > 0 && $totalAxieResult > 1) {
                    $sumEth = $sumEth + $axie['auction']['currentPrice'] / 100000000000000000;
                    $sumUsd = $sumUsd + (float) $axie['auction']['currentPriceUSD'];
                    $summedForAverage++;
                }
                $count++;

                $prices[] = [
                    'price' => (float) $axie['auction']['currentPriceUSD'],
                    'axieEntity' => $axieEntity,
                    'axie' => $axie,
                ];
            }

            usort($prices, function($axie1, $axie2) {
                if ($axie1['axie']['auction']['currentPriceUSD'] == $axie2['axie']['auction']['currentPriceUSD']) {
                    return 0;
                }
                return ($axie1['axie']['auction']['currentPriceUSD'] < $axie2['axie']['auction']['currentPriceUSD']) ? -1 : 1;
            });

            if (sizeof($prices) > 0) {
                if ( sizeof($prices) >= 2 ) {
                    $crawl->setSecondLowestPriceUsd($prices[1]['price']);
                    $crawl->setSecondLowestPriceAxie($prices[1]['axieEntity']);
                } else {
                    $crawl->setSecondLowestPriceUsd($prices[0]['price']);
                    $crawl->setSecondLowestPriceAxie($prices[0]['axieEntity']);
                }
            }

            if ($lowestPriceEth !== PHP_INT_MAX) {
                $crawl->setLowestPriceEth(round($lowestPriceEth, 4));
            }
            if ($lowestPriceUsd !== PHP_INT_MAX) {
                $crawl->setLowestPriceUsd($lowestPriceUsd);
            }
            if ($highestPriceEth !== 0) {
                $crawl->setHighestPriceEth(round($highestPriceEth, 4));
            }
            if ($highestPriceUsd !== 0) {
                $crawl->setHighestPriceUsd($highestPriceUsd);
            }
            if ($summedForAverage !== 0) {
                $crawl->setAveragePriceEth(round($sumEth / $summedForAverage, 4));
                $crawl->setAveragePriceUsd(round($sumUsd / $summedForAverage, 4));
            }
            $crawl->setNumberOfValidAxies($count);
        }

        $this->em->persist($crawl);
        $this->em->persist($watchlist);

        return $output;
    }

    public function crawlPaginated(SymfonyStyle $io = null,$crawlSessionUlid = null) {

        if (null !== $io) {
            $this->io = $io;
        }

        if (null === $crawlSessionUlid) {
            $crawlSessionUlid = new Ulid();
        }


        $client = HttpClient::create();

        $watchlists = $this->watchlistRepo->findBy(['shouldCrawlMorePage' => true], ['orderWeight' => 'DESC']);

        $output = [];
        $output['axiesAdded'] = [];

        foreach($watchlists as $watchlist) {

            $this->log('processing watchlist: ' . $watchlist->getId() . ' ' . $watchlist->getName());

            $payload = json_decode($watchlist->getPayload(), true);
            $from = $payload['variables']['from'];
            $totalResult = null;
            $isLastPage = false;
            $isError = false;
            $totalNumberOfPages = null;
            $currentPage = 1;
            while( $isLastPage === false && $isError === false ) {

                $payload['variables']['from'] = $from;
                $payload['variables']['size'] = static::NUMBER_OF_RESULTS_FOR_PAGINATED;
                $fetchPayload = [
                    'url' => 'https://axieinfinity.com/graphql-server-v2/graphql',
                    'payload' => [
                        'json' => $payload,
                        'user_data' => [
                            'watchlistId' => $watchlist->getId(),
                            'request' => json_encode($payload),
                            'from' => $from,
                        ]
                    ],
                ];
                $response = $client->request('POST', $fetchPayload['url'], $fetchPayload['payload']);


                $crawl = new MarketplaceCrawl($response->getInfo('user_data')['request'], new \DateTime('now', new \DateTimeZone('UTC')));
                $crawl
                    ->setCrawlSessionUlid($crawlSessionUlid)
                    ->setMarketplaceWatchlist($watchlist)
                ;

                try {
                    $statusCode = $response->getStatusCode();
                } catch (TransportExceptionInterface $e) {
                    $isError = true;
                    $this->em->persist($crawl);
                    $this->em->flush();
                    $this->log( '> cannot fetch API response: ' . $e->getMessage() . ' for watchlist id: ' . $response->getInfo('user_data')['watchlistId']  );
                    continue;
                }

                if ( 200 !== $statusCode ) {
                    $isError = true;
                    $crawl->setStatusCode($statusCode);
                    $this->em->persist($crawl);
                    $this->em->flush();
                    $this->log( '> API returned non-200 status code: ' . $statusCode . ' for watchlist id: ' . $response->getInfo('user_data')['watchlistId']  );
                    continue;
                }

                $content = $response->toArray();

                $crawl
                    ->setResponse(json_encode($content))
                ;

                if (empty($content['data']['axies']['total'])) {
                    $isError = true;
                    $this->em->persist($crawl);
                    $this->em->flush();
                    $this->log( '> Cannot get total number of Axies ' . ' for watchlist id: ' . $response->getInfo('user_data')['watchlistId'] . ' from: ' . $from   );
                    continue;
                }

                if ( ! empty($content['errors']) || empty($content['data']['axies']) || 1 > (int) $content['data']['axies']['total']) {
                    $isError = true;
                    $crawl->setIsValid(false);
                    $this->em->persist($crawl);
                    $this->em->flush();
                    $this->log( '> API response contains error ' . ' for watchlist id: ' . $response->getInfo('user_data')['watchlistId']  ) . ' from: ' . $from;
                    continue;
                } else {
                    $crawl->setIsValid(true);
                    $this->em->persist($crawl);
                    $this->em->flush();
                }


                if (null === $totalResult && null === $totalNumberOfPages) {
                    $totalResult = $content['data']['axies']['total'];
                    $totalNumberOfPages = ceil( $totalResult / static::NUMBER_OF_RESULTS_FOR_PAGINATED );
                }

                // check if the first axie costs more than 800 USD
                if ( 800 <= (float) $content['data']['axies']['results'][0]['auction']['currentPriceUSD']) {
                    $this->log( '> done ' . ' for watchlist id: ' . $response->getInfo('user_data')['watchlistId']  ) ;
                    $isLastPage = true;
                    continue;
                }

                if ( $totalNumberOfPages === $currentPage || $currentPage > $totalNumberOfPages ) {
                    $this->log( '> done ' . ' for watchlist id: ' . $response->getInfo('user_data')['watchlistId']  ) ;
                    $isLastPage = true;
                    continue;
                }

                $output = $this->processResponse($crawlSessionUlid, $response, $output);

                $from = $from + self::NUMBER_OF_RESULTS_FOR_PAGINATED;
                $currentPage++;

            }

            // read the response of the first call
            // $output = $this->processResponse($crawlSessionUlid, $response, $output);
            // get total
            // get number of pages = ceil( total / static::NUMBER_OF_RESULTS_FOR_PAGINATE )

            // while, not last page, not error, price of the first item is greater than 800 USD
            // call next page
            // $output = $this->processResponse($crawlSessionUlid, $response, $output);
            // so on.

        }

        return $output;

    }

    public function crawlAll($crawlSessionUlid = null) {

        if (null === $crawlSessionUlid) {
            $crawlSessionUlid = new Ulid();
        }

        $client = HttpClient::create();

        $watchlists = $this->watchlistRepo->findBy(['shouldCrawlMorePage' => false], ['orderWeight' => 'DESC']);
//        $watchlists = [$this->watchlistRepo->find(1)];
        $urlsAndPayloads = [];
        foreach($watchlists as $watchlist) {
            $payload = json_decode($watchlist->getPayload(), true);
            $payload['variables']['from'] = 0;
            $payload['variables']['size'] = static::NUMBER_OF_RESULTS;
            $urlsAndPayloads[] = [
                'url' => 'https://axieinfinity.com/graphql-server-v2/graphql',
                'payload' => [
                    'json' => $payload,
                    'user_data' => [
                        'watchlistId' => $watchlist->getId(),
                        'request' => json_encode($payload)
                    ]
                ],
            ];
        }

        foreach($urlsAndPayloads as $urlsAndPayload) {
            $responses[] = $client->request('POST', $urlsAndPayload['url'], $urlsAndPayload['payload']);
        }

        $output = [];
        $output['axiesAdded'] = [];

        foreach($responses as $response) {
            $output = $this->processResponse($crawlSessionUlid, $response, $output);
            $this->em->flush();
        }

        return $output;

    }

}
