<?php

namespace App\Command;

use App\Entity\MarketplaceCrawl;
use App\Entity\MarketplaceWatchlist;
use App\Repository\AxieRepository;
use App\Repository\MarketplaceCrawlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PopulateCrawlSecondLowestCommand extends Command
{
    protected static $defaultName = 'app:populate-crawl-second-lowest';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var MarketplaceCrawlRepository
     */
    private $crawlRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var AxieRepository
     */
    private $axieRepo;

    public function __construct(string $name = null, MarketplaceCrawlRepository $crawlRepo, EntityManagerInterface $em, AxieRepository $axieRepo)
    {
        parent::__construct($name);
        $this->crawlRepo = $crawlRepo;
        $this->em = $em;
        $this->axieRepo = $axieRepo;
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

        $hasResult = true;
        $runNumber = 0;
        while($hasResult) {
            $qb = $this->crawlRepo->createQueryBuilder('c')
                ->where('c.secondLowestPriceUsd IS NULL')
                ->andWhere('c.marketplaceWatchlist IS NOT NULL')
                ->andWhere('c.numberOfValidAxies > 0')
                ->setMaxResults(10)
            ;

            $crawls = $qb->getQuery()->getResult();

            if (sizeof($crawls) < 1 || empty($crawls) || $runNumber >= 500) {
                $hasResult = false;
                continue;
            }

            $runNumber++;
            $io->note('Run #: ' . $runNumber . ' crawls count: ' . sizeof($crawls));

            /**
             * @var MarketplaceCrawl $crawl
             */
            // TODO: use the new CrawlResultAxie Entity
            $io->error('feature not supported, see TODO: at ' . __FILE__);
            return Command::FAILURE;
            foreach($crawls as $crawl) {

//                $axies = $crawl->getCrawlAxieResults()->toArray();
//                if (sizeof($axies) < 1) {
//                    continue;
//                }
//                usort($axies, function($axie1, $axie2) {
//                    /**
//                     * @var CrawlAxieResult $axie1
//                     * @var CrawlAxieResult $axie2
//                     */
//                   if ($axie1->getPriceUsd() === $axie2->getPriceUsd()) {
//                       return 0;
//                   }
//                    return ($axie1->getPriceUsd() < $axie2->getPriceUsd()) ? -1 : 1;
//                });
//                if (sizeof($axies) >= 2) {
//                    $crawl->setSecondLowestPriceUsd($axies[1]->getPriceUsd());
//                    $crawl->setSecondLowestPriceAxie($axies[1]->getAxie());
//                } else {
//                    $crawl->setSecondLowestPriceUsd($axies[0]->getPriceUsd());
//                    $crawl->setSecondLowestPriceAxie($axies[1]->getAxie());
//                }
//                $this->em->persist($crawl);
            }
            $this->em->flush();
        }

        $io->note(sprintf('There are %d crawls with empty 2nd lowest data', sizeof($crawls)));

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
