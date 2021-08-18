<?php
/**
 * RealtimePriceMonitoringService.php file summary.
 *
 * RealtimePriceMonitoringService.php file description.
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
use App\Entity\AxieHistory;
use App\Entity\AxieRawData;
use App\Entity\CrawlResultAxie;
use App\Entity\MarketplaceCrawl;
use App\Entity\MarketplaceWatchlist;
use App\Repository\MarketplaceWatchlistRepository;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class RealtimePriceMonitoringService.
 *
 * Class RealtimePriceMonitoringService description.
 *
 * @since 1.0.0
 */
class RealtimePriceMonitoringService
{

    /**
     * @var MarketplaceWatchlistRepository
     */
    private $watchlistRepo;

    public function __construct(MarketplaceWatchlistRepository $watchlistRepo) {

        $this->watchlistRepo = $watchlistRepo;
    }


    public function processResponse($response, $output = []) {

        $watchlistId = (int) $response->getInfo('user_data')['watchlistId'];
        $priceNotif = (float) $response->getInfo('user_data')['priceNotif'];

        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            return $output;
        }

        if ($statusCode !== 200) {
            return $output;
        }

        $content = $response->toArray();

        if ( ! empty($content['errors']) || empty($content['data']['axies']) || 1 > (int) $content['data']['axies']['total']) {
            return $output;
        } else {
            foreach($content['data']['axies']['results'] as $axie) {
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

                $axieCurrentPriceUSD = (float) $axie['auction']['currentPriceUSD'];

                if ($axieCurrentPriceUSD <= $priceNotif) {
                    if (!isset($output['notifyPriceAxies'])) {
                        $output['notifyPriceAxies'] = [];
                    }
                    $output['notifyPriceAxies'][] = [
                        'axieId' => $axie['id'],
                        'price' => $axieCurrentPriceUSD
                    ];
                }
            }
        }

        return $output;
    }

    public function getAllPriceHit() {

        $client = HttpClient::create();

        $watchlists = $this->watchlistRepo->findBy(['useRealtimePriceMonitoring' => true]);

        $responses = [];
        $output = [];
        $output['notifyPriceAxies'] = [];
        foreach ($watchlists as $watchlist) {
            if ( empty($watchlist->getNotifyPrice()) ) continue;

            $numberOfResults = 24;
            $payload = json_decode($watchlist->getPayload(), true);
            $payload['variables']['from'] = 0;
            $payload['variables']['size'] = $numberOfResults;
            $urlsAndPayloads[] = [
                'url' => 'https://axieinfinity.com/graphql-server-v2/graphql',
                'payload' => [
                    'json' => $payload,
                    'user_data' => [
                        'watchlistId' => $watchlist->getId(),
                        'priceNotif' => $watchlist->getNotifyPrice(),
                        'request' => json_encode($payload)
                    ]
                ],
            ];

            foreach($urlsAndPayloads as $urlsAndPayload) {
                $responses[] = $client->request('POST', $urlsAndPayload['url'], $urlsAndPayload['payload']);
            }

            foreach($responses as $response) {
                $output = $this->processResponse($response, $output);
            }

        }
        return $output['notifyPriceAxies'];
    }

}
