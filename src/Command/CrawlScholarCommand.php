<?php

namespace App\Command;

use App\Service\ScholarTrackerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CrawlScholarCommand extends Command
{
    protected static $defaultName = 'app:crawl-scholar';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var ScholarTrackerService
     */
    private $scholarTrackerService;

    public function __construct(string $name = null, ScholarTrackerService $scholarTrackerService)
    {
        parent::__construct($name);
        $this->scholarTrackerService = $scholarTrackerService;
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

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $this->scholarTrackerService->saveAllScholarDataNow();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
