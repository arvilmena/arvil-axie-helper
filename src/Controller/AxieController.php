<?php

namespace App\Controller;

use App\Repository\AxieHistoryRepository;
use App\Repository\AxieRepository;
use App\Repository\CrawlAxieResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AxieController extends AbstractController
{

    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var AxieHistoryRepository
     */
    private $axieHistoryRepo;

    public function __construct(AxieRepository $axieRepo, AxieHistoryRepository $axieHistoryRepo)
    {

        $this->axieRepo = $axieRepo;
        $this->axieHistoryRepo = $axieHistoryRepo;
    }

    /**
     * @Route("/axie/{id}", name="axie_id")
     */
    public function id($id): Response
    {
        $axieEntity = $this->axieRepo->find($id);

        if (null === $axieEntity) {
            throw $this->createNotFoundException('Not found.');
        }

        $data = [];
        $data['$axieEntity'] = $axieEntity;
        $data['$crawlAxieResults'] = $this->axieHistoryRepo->findBy(['axie' => $axieEntity], ['id' => 'DESC']);

        return $this->render('axie/id.html.twig', [
            'data' =>  $data,
        ]);
    }
    /**
     * @Route("/axie", name="axie")
     */
    public function index(): Response
    {
        return $this->render('axie/index.html.twig', [
            'controller_name' => 'AxieController',
        ]);
    }
}
