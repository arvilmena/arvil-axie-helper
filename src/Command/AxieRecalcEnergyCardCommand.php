<?php

namespace App\Command;

use App\Entity\Axie;
use App\Entity\AxieCardAbility;
use App\Entity\AxieGenes;
use App\Entity\AxiePart;
use App\Repository\AxieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AxieRecalcEnergyCardCommand extends Command
{
    protected static $defaultName = 'app:axie-recalc-energy-card';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(string $name = null, AxieRepository $axieRepo, EntityManagerInterface $em)
    {
        parent::__construct($name);
        $this->axieRepo = $axieRepo;
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

        $batchSize = 20;
        $i = 1;
        $q = $this->em->createQuery('select a from App\Entity\Axie a WHERE a.sumOfCardEnergy=:one')->setParameter('one', 1);

        /**
         * @var $axieEntity Axie
         */
        foreach($q->toIterable() as $axieEntity) {

            $io->note('processing: ' . $axieEntity->getId());

            $dominantGenes = $this->em->createQuery('select ag from App\Entity\AxieGenes ag WHERE ag.axie=:axie AND ag.geneType=:d')->setParameter('axie', $axieEntity)->setParameter('d', 'd')->getResult();

            $numberOfCardAbilities = 0;
            $sumOfCardEnergy = 0;
            /**
             * @var $dominantGenes AxieGenes[]
             */
            foreach($dominantGenes as $dominantGene) {

                /**
                 * @var $partEntity AxiePart
                 */
                $partEntity = $this->em->createQuery('select p from App\Entity\AxiePart p WHERE p.id=:id')->setParameter('id', $dominantGene->getPart())->getOneOrNullResult();

                if (null === $partEntity) {
                    $io->error('error, cannot find partEntity? but we already populated all parts at this stage 2');
                }
//                $cardAbilityEntity = $partEntity->getCardAbility();
                if (null === $partEntity->getCardAbility()) {
                    continue;
                }
                /**
                 * @var $cardAbilityEntity AxieCardAbility
                 */
                $cardAbilityEntity = $this->em->createQuery('select aca from App\Entity\AxieCardAbility aca WHERE aca.id=:cardAbility')->setParameter('cardAbility', $partEntity->getCardAbility())->getOneOrNullResult();

                if (null === $cardAbilityEntity) {
                    continue;
                }
                $numberOfCardAbilities++;
                $sumOfCardEnergy = $sumOfCardEnergy + $cardAbilityEntity->getEnergy();
            }



            if ( $numberOfCardAbilities !== 4 ) {
                $io->error('error, for some reason, axie: ' . $axieEntity->getId() . ' has ' . $numberOfCardAbilities . ' ability cards.');
            } else {
                $axieEntity->setSumOfCardEnergy($sumOfCardEnergy);

                ++$i;
                if (($i % $batchSize) === 0) {
                    $this->em->flush(); // Executes all updates.
                    $this->em->clear(); // Detaches all objects from Doctrine!
                }
            }
        }

        $this->em->flush(); // Executes all updates.
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
