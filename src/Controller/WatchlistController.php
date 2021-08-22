<?php

namespace App\Controller;

use App\Entity\Axie;
use App\Entity\CrawlAxieResult;
use App\Entity\CrawlResultAxie;
use App\Entity\MarketplaceWatchlist;
use App\Repository\AxieRepository;
use App\Repository\CrawlAxieResultRepository;
use App\Repository\CrawlResultAxieRepository;
use App\Repository\MarketplaceCrawlRepository;
use App\Repository\MarketplaceWatchlistRepository;
use App\Service\RealtimePriceMonitoringService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
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
    /**
     * @var CrawlResultAxieRepository
     */
    private $crawlResultAxieRepo;
    /**
     * @var RealtimePriceMonitoringService
     */
    private $realtimePriceMonitoringService;

    public function __construct(
        MarketplaceWatchlistRepository $watchlistRepo,
        MarketplaceCrawlRepository $crawlRepo,
        AxieRepository $axieRepo,
        CrawlAxieResultRepository $crawlAxieResultRepo,
        CrawlResultAxieRepository $crawlResultAxieRepo,
        RealtimePriceMonitoringService $realtimePriceMonitoringService,
        SerializerInterface $serializer
    ) {

        $this->watchlistRepo = $watchlistRepo;
        $this->crawlRepo = $crawlRepo;
        $this->axieRepo = $axieRepo;
        $this->crawlAxieResultRepo = $crawlAxieResultRepo;
        $this->serializer = $serializer;
        $this->crawlResultAxieRepo = $crawlResultAxieRepo;
        $this->realtimePriceMonitoringService = $realtimePriceMonitoringService;
    }

    /**
     * @Route("/api/realtime/all", name="api_realtime_all")
     */
    public function allRealtimeApi() : Response
    {
        return $this->json($this->realtimePriceMonitoringService->getAllPriceHit());
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
        $watchlists = $this->watchlistRepo->findBy([], ['orderWeight' => 'DESC']);
//        $watchlists = [$this->watchlistRepo->find(12)];
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
                /**
                 * @var $axieResults[] CrawlResultAxie
                 */
                $axieResults = $this->crawlResultAxieRepo->findBy(['crawlUlid' => $lastCrawl->getCrawlSessionUlid(), 'marketplaceWatchlist' => $watchlist], ['date' => 'DESC']);
            } else {
                $axieResults = null;
            }
            $_data['$axieResults'] = $axieResults;
            $watchlistId = $watchlist->getId();

            $defaultTimezone = new \DateTimeZone('UTC');

            $_data['$lowestToday'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('1 day ago', $defaultTimezone));
            $_data['$lowestYesterday'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('2 day ago', $defaultTimezone));
            $_data['$lowest3DaysAgo'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('3 days ago', $defaultTimezone));
//            $_data['$lowestPast6Months'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('6 months ago', $defaultTimezone));
//            $_data['$lowestPastMonth'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('1 month ago', $defaultTimezone));
            $_data['$lowestTwoWeeksAgo'] = $this->crawlRepo->pickSecondLowestPriceBetweenDate($watchlistId, new \DateTime('2 weeks ago', $defaultTimezone));

            $_data['$lowestAverageToday'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('1 day ago', $defaultTimezone));
            $_data['$lowestAverageYesterday'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('2 day ago', $defaultTimezone));
            $_data['$lowestAverage3DaysAgo'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('3 days ago', $defaultTimezone));
//            $_data['$lowestAveragePast6Months'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('6 months ago', $defaultTimezone));
//            $_data['$lowestAveragePastMonth'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('1 month ago', $defaultTimezone));
            $_data['$lowestAverageTwoWeeksAgo'] = $this->crawlRepo->pickWatchlistLowestAveragePriceBetweenDate($watchlistId, new \DateTime('2 weeks ago', $defaultTimezone));


            if ( false === $watchlist->getShouldCrawlMorePage() ) {
                $crawls = $this->crawlRepo->createQueryBuilder('c')
                    ->leftJoin('c.marketplaceWatchlist', 'w')
                    ->addSelect('w')
                    ->where('w.id = :marketplaceId')
                    ->andWhere('c.isValid = true')
                    ->andWhere('c.numberOfValidAxies > 0')
                    ->setParameter('marketplaceId', $watchlist->getId())
                    ->orderBy('c.crawlDate', 'DESC')
                    ->setMaxResults(600)
                    ->getQuery()
                    ->getResult()
                ;
                $crawls = array_reverse($crawls, false);
                $chartData = [];
                foreach($crawls as $crawl) {
                    $chartData[] = $this->serializer->normalize($crawl, null, [
                        AbstractNormalizer::ATTRIBUTES => [
                            'id',
                            'crawlDate',
                            'averagePriceUsd',
                            'lowestPriceUsd',
                            'secondLowestPriceUsd'
                        ]
                    ]);
                }
                $crawlDates = array_column($chartData, 'crawlDate');
                $serializer = new Serializer([new DateTimeNormalizer()]);
                array_walk($crawlDates, function(&$item1, $key, Serializer $serializer) {
                    $date = new \DateTime($item1, new \DateTimeZone('UTC'));
                    $date->setTimezone(new \DateTimeZone("Asia/Manila"));
                    $item1 = $serializer->normalize($date);
                }, $serializer);
                $_data['$chartData']['crawlDate'] = $crawlDates;
                $_data['$chartData']['lowestPriceUsd'] = array_column($chartData, 'lowestPriceUsd');
                $_data['$chartData']['averagePriceUsd'] = array_column($chartData, 'averagePriceUsd');
                $_data['$chartData']['secondLowestPriceUsd'] = array_column($chartData, 'secondLowestPriceUsd');
                $_data['$chartData']['id'] = array_column($chartData, 'id');
            } else {
                $_data['$chartData'] = null;
            }

            $context['watchlists'][] = $_data;
        }

        return $this->render('watchlist/index.html.twig', $context);
    }
}
