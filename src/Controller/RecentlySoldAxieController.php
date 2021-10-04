<?php

namespace App\Controller;

use App\Entity\RecentlySoldAxie;
use App\Repository\RecentlySoldAxieRepository;
use App\Service\RecentlySoldAxieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecentlySoldAxieController extends AbstractController
{

    /**
     * @var RecentlySoldAxieService
     */
    private $recentlySoldAxieService;
    /**
     * @var RecentlySoldAxieRepository
     */
    private $recentlySoldAxieRepo;

    public function __construct(RecentlySoldAxieService $recentlySoldAxieService, RecentlySoldAxieRepository $recentlySoldAxieRepo)
    {
        $this->recentlySoldAxieService = $recentlySoldAxieService;
        $this->recentlySoldAxieRepo = $recentlySoldAxieRepo;
    }

    /**
     * @Route("/recently-sold-axie", name="recently_sold_axie")
     */
    public function index(): Response
    {
        return $this->render('recently_sold_axie/index.html.twig', [
            'controller_name' => 'RecentlySoldAxieController',
        ]);
    }

    /**
     * @Route("/recently-sold-axie/{id}", name="recently_sold_axie_id")
     */
    public function id($id): Response
    {
        /**
         * @var $recentlySoldEntity RecentlySoldAxie
         */
        $recentlySoldEntity = $this->recentlySoldAxieRepo->find($id);

        $recentlySold = $this->recentlySoldAxieService->serialize($recentlySoldEntity);

        $recentlySoldSameCards = $this->recentlySoldAxieService->getSameCards($recentlySoldEntity, $recentlySoldEntity->getAxie());

        return $this->render('recently_sold_axie/id.html.twig', [
            'data' => [
                '$recentlySold' => $recentlySold,
                '$recentlySoldSameCards' => $recentlySoldSameCards,
            ],
        ]);
    }
}
