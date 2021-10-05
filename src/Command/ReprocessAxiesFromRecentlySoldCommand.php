<?php

namespace App\Command;

use App\Entity\RecentlySoldAxie;
use App\Repository\RecentlySoldAxieRepository;
use App\Service\AxieDataService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReprocessAxiesFromRecentlySoldCommand extends Command
{
    protected static $defaultName = 'app:reprocess-axies-from-recently-sold';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var RecentlySoldAxieRepository
     */
    private $recentlySoldAxieRepo;
    /**
     * @var AxieDataService
     */
    private $axieDataService;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(string $name = null, RecentlySoldAxieRepository $recentlySoldAxieRepo, AxieDataService $axieDataService, EntityManagerInterface $em)
    {
        parent::__construct($name);
        $this->recentlySoldAxieRepo = $recentlySoldAxieRepo;
        $this->axieDataService = $axieDataService;
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');


        $q = $this->em->createQuery('SELECT a.id from ' . RecentlySoldAxie::class . ' r INNER JOIN r.axie a WHERE r.priceUsd > 1000 GROUP BY a.id');

        $this->axieDataService->processAllUnprocessed($io, array_column($q->getResult(), 'id'));
//        $this->axieDataService->processAllUnprocessed($io, [1146, 869, 165, 75059, 112969]);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
