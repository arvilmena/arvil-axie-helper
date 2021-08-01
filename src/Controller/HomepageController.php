<?php

namespace App\Controller;

use App\Entity\MarketplaceCrawl;
use App\Repository\MarketplaceCrawlRepository;
use App\Service\CrawlMarketplaceWatchlistService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class HomepageController extends AbstractController
{

    /**
     * @var CrawlMarketplaceWatchlistService
     */
    private $crawlMarketplaceWatchlistService;
    /**
     * @var MarketplaceCrawlRepository
     */
    private $marketplaceCrawlRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(CrawlMarketplaceWatchlistService $crawlMarketplaceWatchlistService, MarketplaceCrawlRepository $marketplaceCrawlRepo, EntityManagerInterface $em, SerializerInterface $serializer) {

        $this->crawlMarketplaceWatchlistService = $crawlMarketplaceWatchlistService;
        $this->marketplaceCrawlRepo = $marketplaceCrawlRepo;
        $this->em = $em;

        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
//        $this->crawlMarketplaceWatchlistService->crawlAll();

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
//        $dql = <<<DQL
//            SELECT c.crawlDate, c.lowestPriceUsd, c.averagePriceUsd, c.marketplaceWatchlist, c.isValid, c.numberOfValidAxies, w
//            FROM \App\Entity\MarketplaceCrawl c
//            JOIN c.marketplaceWatchlist w
//            WHERE c.isValid = true AND c.numberOfValidAxies > 0 AND w.id = 12
//            ORDER BY c.crawl_date DESC
//DQL;
//
//        $crawls = $this->em->createQuery($dql)->setMaxResults(2920)->getResult();

        $crawls = $this->marketplaceCrawlRepo->createQueryBuilder('c')
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

        $output = [];
        foreach($crawls as $crawl) {
            $output[] = $this->serializer->normalize($crawl, null, [
                AbstractNormalizer::ATTRIBUTES => [
                    'crawlDate',
                    'averagePriceUsd',
                    'lowestPriceUsd',
                    'secondLowestPriceUsd',
                    'marketplaceWatchlist' => [
                        'id',
                        'name'
                    ]
                ]
            ]);
        }

        return new Response($this->serializer->serialize($output, 'json'));

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
