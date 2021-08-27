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
use App\Repository\AxieRepository;
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
    /**
     * @var WatchlistAxieNotifyValidationService
     */
    private $watchlistAxieNotifyValidationService;
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var AxieFactoryService
     */
    private $axieFactoryService;
    /**
     * @var AxieDataService
     */
    private $axieDataService;

    public function __construct(MarketplaceWatchlistRepository $watchlistRepo, WatchlistAxieNotifyValidationService $watchlistAxieNotifyValidationService, AxieRepository $axieRepo, AxieFactoryService $axieFactoryService, AxieDataService $axieDataService) {

        $this->watchlistRepo = $watchlistRepo;
        $this->watchlistAxieNotifyValidationService = $watchlistAxieNotifyValidationService;
        $this->axieRepo = $axieRepo;
        $this->axieFactoryService = $axieFactoryService;
        $this->axieDataService = $axieDataService;
    }

    public function generateToastNotification($data) {

        $image = $data['axieImg'];
        $id = $data['axieId'];
        $url = 'https://marketplace.axieinfinity.com/axie/' . $data['axieId'];
        $watchlistName = $data['watchlistName'];
        /**
         * TODO: maybe depend the datetime to user's timezone which we can get if we pass it as argument of AJAX call.
         */
        $currentDatetime = (new \DateTime('now'))->format(\DateTime::RFC3339);

        return <<<HTML
<div id="toast-{$id}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-url="{$url}" data-bs-autohide="false">
  <div class="toast-header">
    <img src="{$image}" class="rounded me-2 img-fluid" style="width: 50px;">
    <strong class="me-auto">{$id}</strong>
    <small><time class="timeago" datetime="{$currentDatetime}">{$currentDatetime}</time></small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
    <p>
        Under: {$watchlistName}
    </p>
    <p>
        <a class="js-view-open" href="{$url}" target="_blank">View</a>
    </p>
  </div>
</div>
HTML;

    }

    public function processResponse($response, $output = []) {

        $watchlistId = (int) $response->getInfo('user_data')['watchlistId'];
        $priceNotif = (int) $response->getInfo('user_data')['priceNotif'];

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

                // simple price hit
                $watchlist = $this->watchlistRepo->find($watchlistId);

                if (
                    null === $watchlist->getExcludeAvgAtkPerCardLte()
                    && null === $watchlist->getExcludeWhenSumOfEnergyLte()
                    && null === $watchlist->getExcludeWhenZeroEnergyCardGte()
                    && null === $watchlist->getExcludeFreaksQualityLte()
                ) {
                    if ( $axieCurrentPriceUSD <= $priceNotif ) {
                        if (!isset($output['notifyPriceAxies'])) {
                            $output['notifyPriceAxies'] = [];
                        }
                        $data = [
                            'axieId' => $axie['id'],
                            'axieImg' => $axie['image'],
                            'price' => $axieCurrentPriceUSD,
                            'watchlistName' => $watchlist->getName()
                        ];
                        $data['toastHtml'] = $this->generateToastNotification($data);
                        $output['notifyPriceAxies'][] = $data;
                    }
                } else {

                    $axieEntity = $this->axieRepo->find($axie['id']);
                    if ( null === $axieEntity ) {
                        $this->axieFactoryService->createAndGetEntity($axie);
                        $this->axieDataService->processAllUnprocessed(null, [$axie['id']]);
                        $axieEntity = $this->axieRepo->find($axie['id']);
                    }

                    if ( null !== $watchlist->getNotifyPrice() && true === $this->watchlistAxieNotifyValidationService->isWatchlistAllowed($watchlist, $axieEntity, $axieCurrentPriceUSD) ) {
                        $data = [
                            'axieId' => $axie['id'],
                            'axieImg' => $axie['image'],
                            'price' => $axieCurrentPriceUSD,
                            'watchlistName' => $watchlist->getName()
                        ];
                        $data['toastHtml'] = $this->generateToastNotification($data);
                        $output['notifyPriceAxies'][] = $data;
                    }

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
