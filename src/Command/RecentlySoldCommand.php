<?php

namespace App\Command;

use App\Service\RecentlySoldAxieService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RecentlySoldCommand extends Command
{
    protected static $defaultName = 'app:recently-sold';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var RecentlySoldAxieService
     */
    private $recentlySoldAxieService;

    public function __construct(string $name = null, RecentlySoldAxieService $recentlySoldAxieService)
    {
        parent::__construct($name);
        $this->recentlySoldAxieService = $recentlySoldAxieService;
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

        $this->recentlySoldAxieService->crawl($io);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
