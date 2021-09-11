<?php
/**
 * AxieCalculateStatService.php file summary.
 *
 * AxieCalculateStatService.php file description.
 *
 * @link       https://project.com
 *
 * @package    Project
 *
 * @subpackage App\Service
 *
 * @author     Arvil Meña <arvil@arvilmena.com>
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Axie;
use App\Entity\AxieGenes;
use App\Repository\AxieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class AxieCalculateStatService.
 *
 * Class AxieCalculateStatService description.
 *
 * @since 1.0.0
 */
class AxieCalculateStatService
{

    /**
     * @var SymfonyStyle
     */
    private $io;
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(AxieRepository $axieRepo, EntityManagerInterface $em) {

        $this->axieRepo = $axieRepo;
        $this->em = $em;
    }

    public function log($msg, $type = 'note') {
        if ($this->io !== null) {
            $this->io->{$type}($msg);
        }
    }

    public function recalculate($axie, SymfonyStyle $io = null, $force = false) {
        $output = [];
        if (null !== $io) {
            $this->io = $io;
        }
        $axieEntity = null;
        if (is_numeric($axie)) {
            $axieEntity = $this->axieRepo->find($axie);
        } elseif ($axie instanceof Axie) {
            $axieEntity = $axie;
        }
        if (null === $axieEntity) {
            $this->log('axie not found');
            return $output;
        }
        /*
            $axieEntity->setAvgAttackPerCard($avgAttackPerCard);
            $axieEntity->setAvgDefencePerCard($avgDefencePerCard);
            $axieEntity->setNumberOfZeroEnergyCard($numberOfZeroEnergyCard);
            $axieEntity->setSumOfCardEnergy($sumOfCardEnergy);
         */
        if (
            false === $force
            && null !== $axieEntity->getAvgAttackPerCard()
            && null !== $axieEntity->getAvgDefencePerCard()
            && null !== $axieEntity->getNumberOfZeroEnergyCard()
            && (null !== $axieEntity->getSumOfCardEnergy() || $axieEntity->getSumOfCardEnergy() > 1 )
        ) {
            $output['$avgAttackPerCard'] = $axieEntity->getAvgAttackPerCard();
            $output['$avgDefencePerCard'] = $axieEntity->getAvgDefencePerCard();
            $output['$sumOfCardEnergy'] = $axieEntity->getSumOfCardEnergy();
            $output['$numberOfZeroEnergyCard'] = $axieEntity->getNumberOfZeroEnergyCard();
            $output['$axieEntity'] = $axieEntity;
            return $output;
        }

        $this->log('calculating atks, defs for axie: ' . $axieEntity->getId());
        $_genes = $axieEntity->getGenes();

        $dominantGenes = $_genes->filter(function(AxieGenes $ag) {
            return trim(strtolower((string) $ag->getGeneType())) === 'd';
        });

        $numberOfCardAbilities = 0;
        $avgAttackPerCard = 0;
        $avgDefencePerCard = 0;
        $sumOfCardEnergy = 0;
        $numberOfZeroEnergyCard = 0;
        /**
         * @var $dominantGenes AxieGenes[]
         */
        foreach($dominantGenes as $dominantGene) {
            $partEntity = $dominantGene->getPart();
            if (null === $partEntity) {
                $this->log('error, cannot find partEntity? but we already populated all parts at this stage 2', 'error');
            }
            $cardAbilityEntity = $partEntity->getCardAbility();
            if (null === $cardAbilityEntity) {
                continue;
            }
            $numberOfCardAbilities++;

            $cardAttack = $cardAbilityEntity->getAttack();
            if ( $cardAbilityEntity->getId() === 'beast-back-12' ) { // Furball, attacks 3 times
                $cardAttack = 120;
            }
            $avgAttackPerCard = $avgAttackPerCard + $cardAttack;

            $avgDefencePerCard = $avgDefencePerCard + $cardAbilityEntity->getDefence();

            if ( 0 === (int) $cardAbilityEntity->getEnergy() ) {
                $numberOfZeroEnergyCard++;
            }
            $sumOfCardEnergy = $sumOfCardEnergy + $cardAbilityEntity->getEnergy();
        }

        if ( $numberOfCardAbilities !== 4 ) {
            $this->log('error, for some reason, axie: ' . $axieEntity->getId() . ' has ' . $numberOfCardAbilities . ' ability cards.', 'error');
        } else {
            $avgAttackPerCard = $avgAttackPerCard / $numberOfCardAbilities;
            $avgDefencePerCard = $avgDefencePerCard / $numberOfCardAbilities;
            $axieEntity->setAvgAttackPerCard($avgAttackPerCard);
            $axieEntity->setAvgDefencePerCard($avgDefencePerCard);
            $axieEntity->setNumberOfZeroEnergyCard($numberOfZeroEnergyCard);
            $axieEntity->setSumOfCardEnergy($sumOfCardEnergy);
            $this->em->persist($axieEntity);
            $this->em->flush();

            $output['$avgAttackPerCard'] = $avgAttackPerCard;
            $output['$avgDefencePerCard'] = $avgDefencePerCard;
            $output['$sumOfCardEnergy'] = $sumOfCardEnergy;
            $output['$numberOfZeroEnergyCard'] = $numberOfZeroEnergyCard;
            $output['$axieEntity'] = $axieEntity;
        }

        return $output;

    }

}
