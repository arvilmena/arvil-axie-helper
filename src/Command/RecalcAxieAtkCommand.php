<?php

namespace App\Command;

use App\Repository\AxieRepository;
use App\Service\AxieCalculateStatService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RecalcAxieAtkCommand extends Command
{
    protected static $defaultName = 'app:recalc-axie-atk';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var AxieCalculateStatService
     */
    private $axieCalculateStatService;

    public function __construct(string $name = null, AxieRepository $axieRepo, AxieCalculateStatService $axieCalculateStatService)
    {
        parent::__construct($name);
        $this->axieRepo = $axieRepo;
        $this->axieCalculateStatService = $axieCalculateStatService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('force', null, InputOption::VALUE_OPTIONAL, 'Should force recalculate all?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('force')) {
            // ...
        }

        $force = $input->getOption('force') ?? false;
        $force = filter_var($force, FILTER_VALIDATE_BOOLEAN);

        $qb = $this->axieRepo->createQueryBuilder('a');
        $axies = $qb
            ->where($qb->expr()->isNotNull('a.avgAttackPerCard'))
            ->getQuery()
            ->getResult();

        foreach ($axies as $axie) {
            $this->axieCalculateStatService->recalculate($axie, $io, $force);
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
