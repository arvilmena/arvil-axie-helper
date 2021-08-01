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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

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
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        MarketplaceWatchlistRepository $watchlistRepo,
        MarketplaceCrawlRepository $crawlRepo,
        AxieRepository $axieRepo,
        CrawlAxieResultRepository $crawlAxieResultRepo,
        SerializerInterface $serializer
    ) {

        $this->watchlistRepo = $watchlistRepo;
        $this->crawlRepo = $crawlRepo;
        $this->axieRepo = $axieRepo;
        $this->crawlAxieResultRepo = $crawlAxieResultRepo;
        $this->serializer = $serializer;
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
//        $watchlists = $this->watchlistRepo->findAll();
        $watchlists = [$this->watchlistRepo->find(12)];
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

            $defaultTimezone = new \DateTimeZone('UTC');

            $_data['$lowestToday'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('1 day ago', $defaultTimezone));
            $_data['$lowestYesterday'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('2 day ago', $defaultTimezone));
            $_data['$lowest3DaysAgo'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('3 days ago', $defaultTimezone));
            $_data['$lowestPast6Months'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('6 months ago', $defaultTimezone));
            $_data['$lowestPastMonth'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('1 month ago', $defaultTimezone));
            $_data['$lowestTwoWeeksAgo'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('2 weeks ago', $defaultTimezone));

            $_data['$lowestAverageToday'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('1 day ago', $defaultTimezone));
            $_data['$lowestAverageYesterday'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('2 day ago', $defaultTimezone));
            $_data['$lowestAverage3DaysAgo'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('3 days ago', $defaultTimezone));
            $_data['$lowestAveragePast6Months'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('6 months ago', $defaultTimezone));
            $_data['$lowestAveragePastMonth'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('1 month ago', $defaultTimezone));
            $_data['$lowestAverageTwoWeeksAgo'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('2 weeks ago', $defaultTimezone));

            $crawls = $this->crawlRepo->createQueryBuilder('c')
                ->leftJoin('c.marketplaceWatchlist', 'w')
                ->addSelect('w')
                ->where('w.id = :marketplaceId')
                ->andWhere('c.isValid = true')
                ->andWhere('c.numberOfValidAxies > 0')
                ->setParameter('marketplaceId', 12)
                ->setMaxResults(2920)
                ->getQuery()
                ->getResult()
            ;
            $chartData = [];
            foreach($crawls as $crawl) {
                $chartData[] = $this->serializer->normalize($crawl, null, [
                    AbstractNormalizer::ATTRIBUTES => [
                        'crawlDate',
                        'averagePriceUsd',
                        'lowestPriceUsd',
                        'secondLowestPriceUsd'
                    ]
                ]);
            }
            $_data['$chartData'] = $chartData;

            $context['watchlists'][] = $_data;
        }

        return $this->render('watchlist/index.html.twig', $context);
    }
}
