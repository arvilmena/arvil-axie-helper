<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarketplaceCrawlController extends AbstractController
{
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
