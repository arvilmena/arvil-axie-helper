<?php

namespace App\Controller;

use App\Entity\Scholar;
use App\Entity\ScholarHistory;
use App\Repository\ScholarHistoryRepository;
use App\Repository\ScholarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ScholarController extends AbstractController
{

    /**
     * @var ScholarRepository
     */
    private $scholarRepo;
    /**
     * @var ScholarHistoryRepository
     */
    private $scholarHistoryRepo;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(ScholarRepository $scholarRepo, ScholarHistoryRepository $scholarHistoryRepo, SerializerInterface $serializer)
    {

        $this->scholarRepo = $scholarRepo;
        $this->scholarHistoryRepo = $scholarHistoryRepo;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/scholar", name="scholar")
     */
    public function index(): Response
    {

        $context = ['scholars' => []];

        /**
         * @var $scholars Scholar[]
         */
        $scholars = $this->scholarRepo->findAll();

        foreach($scholars as $scholar) {


            /**
             * @var $histories ScholarHistory[]
             */
            $histories =  $this->scholarHistoryRepo->getScholarHistories($scholar->getId());

            foreach($histories as $history) {
                $context['scholars'][$scholar->getId()]['$histories'][] = $this->serializer->normalize($history, null, [
                    AbstractNormalizer::ATTRIBUTES => [
                        'date',
                        'gameSlp',
                        'elo',
                        'rank'
                    ]
                ]) ;
                $context['scholars'][$scholar->getId()]['$chartData']['dates'][] = $history->getDate()->format('Y-m-d H:i:s');
                $context['scholars'][$scholar->getId()]['$chartData']['gameSlp'][] = $history->getGameSlp();
                $context['scholars'][$scholar->getId()]['$chartData']['elo'][] = $history->getElo();
                $context['scholars'][$scholar->getId()]['$chartData']['rank'][] = $history->getRank();
            }

            $context['scholars'][$scholar->getId()]['$scholarEntity'] = $scholar;
        }



        return $this->render('scholar/index.html.twig', $context);
    }
}
