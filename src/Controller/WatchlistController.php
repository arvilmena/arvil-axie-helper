<?php

namespace App\Controller;

use App\Entity\CrawlAxieResult;
use App\Entity\MarketplaceWatchlist;
use App\Repository\AxieRepository;
use App\Repository\CrawlAxieResultRepository;
use App\Repository\MarketplaceCrawlRepository;
use App\Repository\MarketplaceWatchlistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WatchlistController extends AbstractController
{
    /**
     * @var MarketplaceWatchlistRepository
     */
    private $watchlistRepo;
    /**
     * @var MarketplaceCrawlRepository
     */
    private $crawlRepo;
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var CrawlAxieResultRepository
     */
    private $crawlAxieResultRepo;

    public function __construct(
        MarketplaceWatchlistRepository $watchlistRepo,
        MarketplaceCrawlRepository $crawlRepo,
        AxieRepository $axieRepo,
        CrawlAxieResultRepository $crawlAxieResultRepo
    ) {

        $this->watchlistRepo = $watchlistRepo;
        $this->crawlRepo = $crawlRepo;
        $this->axieRepo = $axieRepo;
        $this->crawlAxieResultRepo = $crawlAxieResultRepo;
    }

    /**
     * @Route("/watchlist", name="watchlist")
     */
    public function index(): Response
    {
        $context = [];

        /**
         * @var $watchlists MarketplaceWatchlist[]
         */
        $watchlists = $this->watchlistRepo->findAll();
        foreach($watchlists as $watchlist) {
            $_data = [
                '$entity' => $watchlist,
            ];
            $payload = json_decode($watchlist->getPayload(), true);
            $criterias = $payload['variables']['criteria'];
            foreach(['region', 'bodyShapes', 'stages', 'numMystic', 'title', 'breedable'] as $prop) {
                unset($criterias[$prop]);
            }

            $query = [];
            foreach($criterias as $key => $value) {
                if (null === $value) {continue;}
                if (empty($value)) {continue;}
                if ( is_array($value) ) {
                    foreach ($value as $v) {
                        $paramKey = $key;
                        if ( $key === 'classes' ) {
                            $paramKey = 'class';
                        } elseif ( $key === 'parts' ) {
                            $paramKey = 'part';
                        }
                        $query[] = $paramKey .'=' . $v;
                    }
                }
            }
            $_data['marketplaceUrl'] = 'https://marketplace.axieinfinity.com/axie?' . implode('&', $query);


            foreach(['skill', 'speed', 'morale', 'classes', 'pureness', 'breedCount'] as $prop) {
                if ( is_array($criterias[$prop]) && sizeof($criterias[$prop]) === 0) {
                    unset($criterias[$prop]);
                } elseif ($criterias[$prop] === null) {
                    unset($criterias[$prop]);
                }
            }
            $_data['apiCriterias'] = $criterias;

            $lastCrawl = $this->crawlRepo->findOneBy(
                [
                    'marketplaceWatchlist' => $watchlist,
                    'isValid' => true
                ],
                [
                    'id' => 'DESC'
                ]
            );
            $_data['$lastCrawlEntity'] = $lastCrawl;

            if ( null !== $lastCrawl ) {
                $axieResults = $this->crawlAxieResultRepo->findBy(['crawl' => $lastCrawl], ['priceEth' => 'ASC']);
                if (sizeof($axieResults) > 10) {
                    $axieResults = array_slice($axieResults, 0, 10);
                }
            } else {
                $axieResults = null;
            }
            $_data['$axieResults'] = $axieResults;
            $watchlistId = $watchlist->getId();

            $_data['$lowestAverageToday'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('1 day ago'));
            $_data['$lowestAverageYesterday'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('2 day ago'));
            $_data['$lowestAverage3DaysAgo'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('3 days ago'));
            $_data['$lowestAveragePast6Months'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('6 months ago'));
            $_data['$lowestAveragePastMonth'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('1 month ago'));
            $_data['$lowestAverageTwoWeeksAgo'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('2 weeks ago'));

            $_data['$lowestToday'] = $this->crawlRepo->pickWatchlistLowestPriceBetweenDate($watchlistId, new \DateTime('1 day ago'));
            $_data['$lowestYesterday'] = $this->crawlRepo->pickWatchlistLowestPriceBetweenDate($watchlistId, new \DateTime('2 day ago'));
            $_data['$lowest3DaysAgo'] = $this->crawlRepo->pickWatchlistLowestPriceBetweenDate($watchlistId, new \DateTime('3 days ago'));
            $_data['$lowestPast6Months'] = $this->crawlRepo->pickWatchlistLowestPriceBetweenDate($watchlistId, new \DateTime('6 months ago'));
            $_data['$lowestPastMonth'] = $this->crawlRepo->pickWatchlistLowestPriceBetweenDate($watchlistId, new \DateTime('1 month ago'));
            $_data['$lowestTwoWeeksAgo'] = $this->crawlRepo->pickWatchlistLowestPriceBetweenDate($watchlistId, new \DateTime('2 weeks ago'));

            $context['watchlists'][] = $_data;
        }

        return $this->render('watchlist/index.html.twig', $context);
    }
}
