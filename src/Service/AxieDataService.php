<?php
/**
 * AxieDataService.php file summary.
 *
 * AxieDataService.php file description.
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
use App\Entity\AxieCardAbility;
use App\Entity\AxieGenePassingRate;
use App\Entity\AxieGenes;
use App\Entity\AxiePart;
use App\Entity\AxieRawData;
use App\Repository\AxieCardAbilityRepository;
use App\Repository\AxieGenesRepository;
use App\Repository\AxiePartRepository;
use App\Repository\AxieRawDataRepository;
use App\Repository\AxieRepository;
use App\Repository\CrawlAxieResultRepository;
use App\Util\AxieGeneUtil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class AxieDataService.
 *
 * Class AxieDataService description.
 *
 * @since 1.0.0
 */
class AxieDataService
{
    /**
     * @var AxieGenesRepository
     */
    private $axieGenesRepo;
    /**
     * @var AxiePartRepository
     */
    private $axiePartRepo;
    /**
     * @var AxieCardAbilityRepository
     */
    private $axieCardAbilityRepo;
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var SymfonyStyle
     */
    private $io;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var AxieRawDataRepository
     */
    private $axieRawDataRepo;
    /**
     * @var CrawlAxieResultRepository
     */
    private $crawlAxieResultRepo;
    /**
     * @var AxieCalculateStatService
     */
    private $axieCalculateStatService;

    public function __construct(
        AxieRepository $axieRepo,
        AxieGenesRepository $axieGenesRepo,
        AxiePartRepository $axiePartRepo,
        AxieCardAbilityRepository $axieCardAbilityRepo,
        AxieRawDataRepository $axieRawDataRepo,
        CrawlAxieResultRepository $crawlAxieResultRepo,
        AxieCalculateStatService $axieCalculateStatService,
        EntityManagerInterface $em
    )
    {
        $this->axieGenesRepo = $axieGenesRepo;
        $this->axiePartRepo = $axiePartRepo;
        $this->axieCardAbilityRepo = $axieCardAbilityRepo;
        $this->axieRepo = $axieRepo;
        $this->axieRawDataRepo = $axieRawDataRepo;
        $this->em = $em;
        $this->crawlAxieResultRepo = $crawlAxieResultRepo;
        $this->axieCalculateStatService = $axieCalculateStatService;
    }

    public function log($msg, $type = 'note') {
        if (null !== $this->io) {
            $this->io->{$type}($msg);
        }
    }

    public function processAllUnprocessed(SymfonyStyle $io = null, $specificAxieIds = []) {
        if (null !== $io) {
            $this->io = $io;
        }
        if ( empty($specificAxieIds) ) {
            $toProcess = $this->axieRepo->findBy(['isProcessed' => false], ['id' => 'ASC']);
        } else {
            $this->log('Starting Axie Data population for ' . count($specificAxieIds) . ' Ids: ' . implode(',', $specificAxieIds));
            $qb = $this->axieRepo->createQueryBuilder('a')
                ->where('a.isProcessed = false');

            $qb->andWhere($qb->expr()->in('a.id', $specificAxieIds))
                ->orderBy('a.id', 'ASC');
            $toProcess = $qb->getQuery()->getResult();
        }
        if (empty($toProcess)) {
            $this->log('nothing to process');
            return;
        }

        $client = HttpClient::create();

        $_toProcess = array_chunk($toProcess, 5);

        foreach($_toProcess as $_tp) {
            $responses = [];

            foreach($_tp as $axieEntity) {

                $id = $axieEntity->getId();

                $this->log('processing Axie id# ' . $id);

                $body = '{"operationName":"GetAxieDetail","variables":{"axieId":"' . $id . '"},"query":"query GetAxieDetail($axieId: ID!) {\n  axie(axieId: $axieId) {\n    ...AxieDetail\n    __typename\n  }\n}\n\nfragment AxieDetail on Axie {\n  id\n  image\n  class\n  chain\n  name\n  genes\n  owner\n  birthDate\n  bodyShape\n  class\n  sireId\n  sireClass\n  matronId\n  matronClass\n  stage\n  title\n  breedCount\n  level\n  figure {\n    atlas\n    model\n    image\n    __typename\n  }\n  parts {\n    ...AxiePart\n    __typename\n  }\n  stats {\n    ...AxieStats\n    __typename\n  }\n  auction {\n    ...AxieAuction\n    __typename\n  }\n  ownerProfile {\n    name\n    __typename\n  }\n  battleInfo {\n    ...AxieBattleInfo\n    __typename\n  }\n  children {\n    id\n    name\n    class\n    image\n    title\n    stage\n    __typename\n  }\n  __typename\n}\n\nfragment AxieBattleInfo on AxieBattleInfo {\n  banned\n  banUntil\n  level\n  __typename\n}\n\nfragment AxiePart on AxiePart {\n  id\n  name\n  class\n  type\n  specialGenes\n  stage\n  abilities {\n    ...AxieCardAbility\n    __typename\n  }\n  __typename\n}\n\nfragment AxieCardAbility on AxieCardAbility {\n  id\n  name\n  attack\n  defense\n  energy\n  description\n  backgroundUrl\n  effectIconUrl\n  __typename\n}\n\nfragment AxieStats on AxieStats {\n  hp\n  speed\n  skill\n  morale\n  __typename\n}\n\nfragment AxieAuction on Auction {\n  startingPrice\n  endingPrice\n  startingTimestamp\n  endingTimestamp\n  duration\n  timeLeft\n  currentPrice\n  currentPriceUSD\n  suggestedPrice\n  seller\n  listingIndex\n  state\n  __typename\n}\n"}';

                $responses[] = $client->request('POST', 'https://axieinfinity.com/graphql-server-v2/graphql', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ],
                    'body' => $body,
                    'user_data' => [
                        'axieId' => $id
                    ]
                ]);
            } # foreach($_tp as $axieEntity) {

            foreach ($client->stream($responses, 10) as $response => $chunk) {
                try {
                    if ($chunk->isTimeout()) {
                        // $response staled for more than 1.5 seconds
                        $this->log('> error: timed out. axie id#: ' . $response->getInfo('user_data')['axieId'], 'error');
                        $response->cancel();
                    } elseif ($chunk->isFirst()) {
                        // headers of $response just arrived
                        // $response->getHeaders() is now a non-blocking call
                        if ( 200 !== $response->getStatusCode() ) {
                            $this->log('> error, status code: ' . $response->getStatusCode() . ' axie id#: ' . $response->getInfo('user_data')['axieId'], 'error');
                            $response->cancel();
                        }
                    } elseif ($chunk->isLast()) {
                        $content = $response->getContent(false);
                        $content = json_decode($content, true);
                        if ( empty($content['data']['axie']) ) {
                            $this->log('> error, cannot determine structure of response'. ' axie id#: ' . $response->getInfo('user_data')['axieId'], 'error');
                            continue;
                        }

                        $axieData = $content['data']['axie'];
                        if ( empty($axieData['stage']) || 4 !== $axieData['stage'] ) {
                            $this->log('> error, Axie is not yet adult.' . ' axie id#: ' . $response->getInfo('user_data')['axieId'], 'error');
                            continue;
                        }

                        if (
                            empty($axieData['id'])
                            || empty($axieData['class'])
                            || empty($axieData['genes'])
                            || empty($axieData['parts'])
                            || empty($axieData['stats'])
                        ) {
                            $this->log('> error, data doesnt contain required fields.' . ' axie id#: ' . $response->getInfo('user_data')['axieId'], 'error');
                            continue;
                        }

                        /**
                         * @var $axieEntity Axie
                         */
                        $axieEntity = $this->axieRepo->find($axieData['id']);
                        if (null === $axieEntity) {
                            $this->log('> error, for some reason, we cannot find the axie in our db.' . ' axie id#: ' . $response->getInfo('user_data')['axieId'] , 'error');
                        }

                        $axieGenes = new AxieGeneUtil(trim($axieData['genes']));

                        $axieEntity
                            ->setEncodedGenes( trim($axieData['genes']) )
                            ->setClass( strtolower($axieData['class']) )
                            ->setHp( $axieData['stats']['hp'] )
                            ->setSpeed( $axieData['stats']['speed'] )
                            ->setMorale( $axieData['stats']['morale'] )
                            ->setSkill( $axieData['stats']['skill'] )
                            ->setDominantClassPurity( $axieGenes->getDominantClassPurity() )
                            ->setR1ClassPurity( $axieGenes->getR1ClassPurity() )
                            ->setR2ClassPurity($axieGenes->getR2ClassPurity())
                            ->setPureness( $axieGenes->getPureness() )
                            ->setQuality($axieGenes->getQuality())
                        ;
                        $this->em->persist($axieEntity);
                        $this->em->flush();

                        $rawDataEntity = $this->axieRawDataRepo->find($axieEntity);
                        if (null === $rawDataEntity) {
                            $rawDataEntity = new AxieRawData($axieEntity);
                        }
                        $rawDataEntity->setRawData(json_encode($axieData));
                        $this->em->persist($rawDataEntity);
                        $this->em->flush();

                        $axieParts = $axieEntity->getParts();
                        $shouldPopulateAxieParts = (count($axieParts) !== 6);
                        if ($shouldPopulateAxieParts) {
                            $axieParts->clear();
                        }

                        foreach($axieData['parts'] as $part) {
                            $partEntity = $this->axiePartRepo->find($part['id']);
                            if (null === $partEntity) {
                                $partEntity = new AxiePart($part['id']);
                                $partEntity
                                    ->setName($part['name'])
                                    ->setType(strtolower($part['type']))
                                    ->setClass(strtolower($part['class']));
                                $this->em->persist($partEntity);
                                $this->em->flush();
                            }

                            if ( !empty($part['abilities'][0]) ) {
                                $ability = $part['abilities'][0];
                                $cardAbilityEntity = $this->axieCardAbilityRepo->find($ability['id']);
                                if (null === $cardAbilityEntity) {
                                    $this->log('> not found, adding card ability: '. $ability['id'] . ' for axie: ' . $axieEntity->getId());
                                    $cardAbilityEntity = new AxieCardAbility($ability['id']);
                                    $cardAbilityEntity
                                        ->setName($ability['name'])
                                        ->setAttack($ability['attack'])
                                        ->setDefence($ability['defense'])
                                        ->setEnergy($ability['energy'])
                                        ->setDescription($ability['description'])
                                        ->setBackgroundUrl($ability['backgroundUrl'])
                                        ->setAxiePart($partEntity)
                                    ;
                                    $partEntity->setCardAbility($cardAbilityEntity);
                                    $this->em->persist($cardAbilityEntity);
                                    $this->em->persist($partEntity);
                                    $this->em->flush();
                                }
                            }

                            if ($shouldPopulateAxieParts) {
                                $axieEntity->addPart($partEntity);
                            }
                        }
                        if ($shouldPopulateAxieParts) {
                            $this->em->persist($axieEntity);
                            $this->em->flush();
                        }

                        // genes and gene passing rate
                        // if we had to repopulate the parts, then we have to repopulate the genes as well
                        if ($shouldPopulateAxieParts) {
                            $axieEntity->getGenes()->clear();
                            foreach(
                                [
                                    ['geneType' => 'd', 'method' => 'getDominantGenes'],
                                    ['geneType' => 'r1', 'method' => 'getR1Genes'],
                                    ['geneType' => 'r2', 'method' => 'getR2Genes'],
                                ] as $geneTypeMethod
                            ) {
                                $genes = $axieGenes->{$geneTypeMethod['method']}();
                                foreach($genes as $gene) {
                                    $partEntity = $this->axiePartRepo->find($gene['partId']);
                                    if (null === $partEntity) {
                                        $partEntity = new AxiePart($gene['partId']);
                                        $partEntity
                                            ->setName($gene['name'])
                                            ->setType(strtolower($gene['type']))
                                            ->setClass(strtolower($gene['class']))
                                        ;
                                        $this->em->persist($partEntity);
                                        $this->em->flush();
                                    }

                                    $axieGeneEntity = new AxieGenes();
                                    $axieGeneEntity
                                        ->setAxie($axieEntity)
                                        ->setPart($partEntity)
                                        ->setGeneType(strtolower($geneTypeMethod['geneType']))
                                    ;

                                    $cardAbilityEntity = $partEntity->getCardAbility();
                                    if (null !== $cardAbilityEntity) {
                                        $axieGeneEntity->setCardAbility($cardAbilityEntity);
                                    }

                                    $this->em->persist($axieGeneEntity);

                                    $axieEntity->addGene($axieGeneEntity);
                                    $this->em->persist($axieEntity);

                                    $this->em->flush();
                                }
                            }
                            $this->em->persist($axieEntity);
                            $this->em->flush();

                            // Gene passing rate
                            $axieEntity->getGenePassingRates()->clear();
                            foreach($axieGenes->getGenePassingRates() as $gene) {
                                $partEntity = $this->axiePartRepo->find($gene['partId']);
                                if (null === $partEntity) {
                                    $this->log('error, cannot find partEntity? but we already populated all parts at this stage', 'error');
                                    $this->em->flush();
                                    return;
                                }
                                $genePassingRateEntity = new AxieGenePassingRate();
                                $genePassingRateEntity
                                    ->setAxie($axieEntity)
                                    ->setPart($partEntity)
                                    ->setPassingRate($gene['passingRate'])
                                ;
                                $cardAbilityEntity = $partEntity->getCardAbility();
                                if (null !== $cardAbilityEntity) {
                                    $genePassingRateEntity->setAxieCardAbility($cardAbilityEntity);
                                }
                                $this->em->persist($genePassingRateEntity);
                                $this->em->flush();
                            }
                        }

                        $axieEntity->setIsProcessed(true);
                        $this->em->persist($axieEntity);
                        $this->em->flush();

                        // calculate avgAttackPerCard / avgDefencePerCard
                        if ( null === $axieEntity->getAvgAttackPerCard() || null === $axieEntity->getAvgDefencePerCard() ) {
                            // update the last crawl data as well.
                            $calculatedStat = $this->axieCalculateStatService->recalculate($axieEntity, $this->io);
                            if (!empty($calculatedStat)) {
                                $lastCrawlResult = $this->crawlAxieResultRepo->findOneBy(['axie' => $axieEntity], ['crawlDate' => 'DESC']);
                                if (null !== $lastCrawlResult && $lastCrawlResult->getPriceUsd() > 0) {
                                    $axieEntity->setAttackPerUsd($calculatedStat['$avgAttackPerCard'] / $lastCrawlResult->getPriceUsd());
                                    $axieEntity->setDefencePerUsd($calculatedStat['$avgDefencePerCard'] / $lastCrawlResult->getPriceUsd());
                                    $this->em->persist($axieEntity);
                                    $this->em->flush();
                                }
                            }
                        }

                        $this->em->flush();
                    } # } elseif ($chunk->isLast())
                } catch(TransportExceptionInterface $e) {
                    $this->log('> error: ' . $e->getMessage(), 'error');
                    continue;
                }
            } # foreach ($client->stream($responses, 10) as $response => $chunk) {

            $this->log('sleeping for 3 secs');
            sleep(3);
        } # foreach($_toProcess as $_tp)

    }
}
