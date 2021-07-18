<?php

namespace App\Command;

use App\Service\CrawlMarketplaceWatchlistService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CrawlCommand extends Command
{
    protected static $defaultName = 'app:crawl';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var CrawlMarketplaceWatchlistService
     */
    private $crawlMarketplaceWatchlistService;

    public function __construct(string $name = null, CrawlMarketplaceWatchlistService $crawlMarketplaceWatchlistService)
    {
        parent::__construct($name);
        $this->crawlMarketplaceWatchlistService = $crawlMarketplaceWatchlistService;
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

        $this->crawlMarketplaceWatchlistService->crawlAll();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
