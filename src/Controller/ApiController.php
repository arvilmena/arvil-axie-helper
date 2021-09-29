<?php

namespace App\Controller;

use App\Service\RecentlySoldAxieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }


    /**
     * @Route("/api/recently_sold", name="api_recently_sold")
     */
    public function recentlySold(RecentlySoldAxieService $recentlySoldAxieService ): Response
    {
        $recentlySoldAxieService->crawl();
        
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
