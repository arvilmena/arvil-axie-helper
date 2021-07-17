<?php

namespace App\Controller;

use App\Service\CrawlMarketplaceWatchlistService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{

    /**
     * @var CrawlMarketplaceWatchlistService
     */
    private $crawlMarketplaceWatchlistService;

    public function __construct(CrawlMarketplaceWatchlistService $crawlMarketplaceWatchlistService) {

        $this->crawlMarketplaceWatchlistService = $crawlMarketplaceWatchlistService;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $this->crawlMarketplaceWatchlistService->crawlAll();
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
