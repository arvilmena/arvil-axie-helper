<?php

namespace App\Controller;

use App\Repository\CrawlAxieResultRepository;
use App\Repository\MarketplaceCrawlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarketplaceCrawlController extends AbstractController
{

    /**
     * @var MarketplaceCrawlRepository
     */
    private $crawlRepo;
    /**
     * @var CrawlAxieResultRepository
     */
    private $crawlAxieResultRepo;

    public function __construct(MarketplaceCrawlRepository $crawlRepo, CrawlAxieResultRepository $crawlAxieResultRepo) {

        $this->crawlRepo = $crawlRepo;
        $this->crawlAxieResultRepo = $crawlAxieResultRepo;
    }

    /**
     * @Route("/marketplace_crawl/{id}", name="marketplace_crawl_id")
     */
    public function id($id): Response
    {
        $crawlEntity = $this->crawlRepo->find($id);

        if (null === $crawlEntity) {
            throw $this->createNotFoundException('Not found');
        }

        $_data = [];
        $_data['$crawlEntity'] = $crawlEntity;
        $_data['$watchlistEntity'] = $crawlEntity->getMarketplaceWatchlist();

        if ( null !== $crawlEntity ) {
            $axieResults = $this->crawlAxieResultRepo->findBy(['crawl' => $crawlEntity], ['priceUsd' => 'ASC']);
        } else {
            $axieResults = null;
        }
        $_data['$axieResults'] = $axieResults;

        return $this->render('marketplace_crawl/id.html.twig', [
            'data' => $_data,
        ]);
    }
    /**
     * @Route("/marketplace_crawl", name="marketplace_crawl")
     */
    public function index(): Response
    {
        return $this->render('marketplace_crawl/index.html.twig', [
            'controller_name' => 'MarketplaceCrawlController',
        ]);
    }
}
