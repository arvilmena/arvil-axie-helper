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
use App\Entity\CrawlAxieResult;
use App\Entity\MarketplaceCrawl;
use App\Repository\AxieRepository;
use App\Repository\MarketplaceWatchlistRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    /**
     * @var AxieRepository
     */
    private $axieRepo;

    public function __construct(EntityManagerInterface $em, MarketplaceWatchlistRepository $watchlistRepo, AxieRepository $axieRepo)
    {
        $this->em = $em;
        $this->watchlistRepo = $watchlistRepo;
        $this->axieRepo = $axieRepo;
    }

    public function crawlAll() {

        $urlsAndPayloads = [];
        $crawlSessionUlid = new Ulid();

        $watchlists = $this->watchlistRepo->findAll();
//        $watchlists = [$this->watchlistRepo->find(1)];
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

        $client = HttpClient::create();
        $responses = [];
        foreach($urlsAndPayloads as $urlsAndPayload) {
            $responses[] = $client->request('POST', $urlsAndPayload['url'], $urlsAndPayload['payload']);
        }

        foreach ($responses as $response) {

            $crawl = new MarketplaceCrawl($response->getInfo('user_data')['request'], new \DateTime('now', new \DateTimeZone('UTC')));
            $crawl
                ->setCrawlSessionUlid($crawlSessionUlid);

            try {
                $statusCode = $response->getStatusCode();
            } catch (TransportExceptionInterface $e) {
                $this->em->persist($crawl);
                continue;
            }

            $crawl->setStatusCode($statusCode);
            
            if ($statusCode !== 200) {
                $this->em->persist($crawl);
                continue;
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
                    $axieEntity->setRawData(json_encode($axie));
                    $this->em->persist($axieEntity);

                    $axieResult = new CrawlAxieResult();
                    $axieResult
                        ->setCrawl($crawl)
                        ->setAxie($axieEntity);

                    if (isset($axie['breedCount'])) {
                        $axieResult->setBreedCount((int) $axie['breedCount']);
                    }

                    $this->em->persist($axieResult);


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
                    $this->em->persist($axieResult);

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
        }

        $this->em->flush();

    }

}
