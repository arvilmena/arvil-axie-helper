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
use App\Entity\MarketplaceCrawl;
use App\Repository\AxieRepository;
use App\Repository\MarketplaceWatchlistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;

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

    const NUMBER_OF_RESULTS = 100;
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

            if ($response->getStatusCode() !== 200) {
                continue;
            }

            $content = $response->toArray();

            $watchlist = $this->watchlistRepo->find((int) $response->getInfo('user_data')['watchlistId']);
            $crawl = new MarketplaceCrawl($response->getInfo('user_data')['request'], new \DateTime('now'));
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
                $items = 0;
                $sumEth = 0;
                $sumUsd = 0;
                foreach($content['data']['axies']['results'] as $axie) {
                    $axieEntity = $this->axieRepo->find((int) $axie['id']);
                    if (null === $axieEntity) {
                        $axieEntity = new Axie((int) $axie['id']);
                    }
                    $axieEntity->setRawData(json_encode($axie));
                    $this->em->persist($axieEntity);

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

                    $items++;
                    if ($axie['auction']['currentPrice'] < $lowestPriceEth) {
                        $lowestPriceEth = (float) $axie['auction']['currentPrice'] / 100000000000000000;
                    }
                    if ($axie['auction']['currentPrice'] > $highestPriceEth) {
                        $highestPriceEth = (float) $axie['auction']['currentPrice'] / 100000000000000000;
                    }
                    if ($axie['auction']['currentPriceUSD'] < $lowestPriceUsd) {
                        $lowestPriceUsd = (float) $axie['auction']['currentPriceUSD'];
                    }
                    if ($axie['auction']['currentPriceUSD'] > $highestPriceUsd) {
                        $highestPriceUsd = (float) $axie['auction']['currentPriceUSD'];
                    }
                    $sumEth = $sumEth + (float) $axie['auction']['currentPrice'] / 100000000000000000;
                    $sumUsd = $sumUsd + (float) $axie['auction']['currentPriceUSD'];
                }
                echo $lowestPriceEth;
                if ($lowestPriceEth !== PHP_INT_MAX) {
                    $crawl->setLowestPriceEth( $lowestPriceEth);
                }
                if ($lowestPriceUsd !== PHP_INT_MAX) {
                    $crawl->setLowestPriceUsd($lowestPriceUsd);
                }
                if ($highestPriceEth !== 0) {
                    $crawl->setHighestPriceEth($highestPriceEth);
                }
                if ($highestPriceUsd !== 0) {
                    $crawl->setHighestPriceUsd($highestPriceUsd);
                }
                if ($items !== 0) {
                    $crawl->setAveragePriceEth($sumEth / $items);
                    $crawl->setAveragePriceUsd($sumUsd / $items);
                }
            }

            $this->em->persist($crawl);
            $this->em->persist($watchlist);
        }

        $this->em->flush();

    }

}
