<?php
/**
 * RecentlySoldAxieService.php file summary.
 *
 * RecentlySoldAxieService.php file description.
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
use App\Entity\AxieHistory;
use App\Entity\AxiePart;
use App\Entity\RecentlySoldAxie;
use App\Repository\AxieHistoryRepository;
use App\Repository\AxieRepository;
use App\Repository\RecentlySoldAxieRepository;
use Doctrine\ORM\EntityManagerInterface;
use ProxyManager\Exception\ExceptionInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class RecentlySoldAxieService.
 *
 * Class RecentlySoldAxieService description.
 *
 * @since 1.0.0
 */
class RecentlySoldAxieService
{

    /**
     * @var RecentlySoldAxieRepository
     */
    private $recentlySoldAxieRepo;
    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var SymfonyStyle|null
     */
    private $io;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var AxieFactoryService
     */
    private $axieFactoryService;
    /**
     * @var AxieDataService
     */
    private $axieDataService;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var AxieHistoryRepository
     */
    private $axieHistoryRepo;
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(RecentlySoldAxieRepository $recentlySoldAxieRepo, AxieRepository $axieRepo, EntityManagerInterface $em, AxieFactoryService $axieFactoryService, AxieDataService $axieDataService, SerializerInterface $serializer, AxieHistoryRepository $axieHistoryRepo, HttpClientInterface $httpClient)
    {
        $this->recentlySoldAxieRepo = $recentlySoldAxieRepo;
        $this->axieRepo = $axieRepo;
        $this->em = $em;
        $this->axieFactoryService = $axieFactoryService;
        $this->axieDataService = $axieDataService;
        $this->serializer = $serializer;
        $this->axieHistoryRepo = $axieHistoryRepo;
        $this->httpClient = $httpClient;
    }

    public function getMinUsdPrice() {
        return 480;
    }

    private function log($msg, $type = 'note') : void {
        if ($this->io === null) {
            return;
        }
        $this->io->{$type}($msg);
    }
    
    public function serialize(RecentlySoldAxie $_rs) {
        /**
         * @var $_rs RecentlySoldAxie
         */
        $o = [
            'id' => $_rs->getId(),
            'date' => $this->serializer->normalize($_rs->getDate()),
            'price_eth' => $_rs->getPriceEth(),
            'price_usd' => $_rs->getPriceUsd(),
            'breed_count' => $_rs->getBreedCount(),
            '$axieEntity' => $this->serializer->normalize($_rs->getAxie(), null, [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'url',
                    'imageUrl',
                    'dominantClassPurity',
                    'r1ClassPurity',
                    'r2ClassPurity',
                    'pureness',
                    'class',
                    'hp',
                    'speed',
                    'skill',
                    'morale',
                    'quality',
                    'avgAttackPerCard',
                    'avgDefencePerCard',
                    'numberOfZeroEnergyCard',
                    'sumOfCardEnergy',
                ]
            ]),
        ];
        /**
         * @var $parts AxiePart[]
         */
        $parts = $_rs->getAxie()->getParts();
        foreach($parts as $part) {
            $o['$axieParts'][$part->getType()] = [];
            $o['$axieParts'][$part->getType()]['$part'] = $this->serializer->normalize($part, null, [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'type',
                    'class'
                ]
            ]);
            if (null !== $part->getCardAbility()) {
                $o['$axieParts'][$part->getType()]['$cardAbility'] = $this->serializer->normalize($part->getCardAbility(), null, [
                    AbstractNormalizer::ATTRIBUTES => [
                        'id',
                        'name',
                        'attack',
                        'defence',
                        'energy',
                        'description',
                        'backgroundUrl',
                    ]
                ]);
            } else {
                $o['$axieParts'][$part->getType()]['$cardAbility'] = null;
            }
        }

        /**
         * @var $genes AxieGenes[]
         */
        $genes = $_rs->getAxie()->getGenes();
        $o['$axieGenes'] = [
            'd' => [],
            'r1' => [],
            'r2' => []
        ];
        foreach ($genes as $gene) {
            $o['$axieGenes'][$gene->getGeneType()][$gene->getPart()->getType()] = $this->serializer->normalize($gene->getPart(), null, [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'type',
                    'class'
                ]
            ]);
        }

        return $o;
    }

    public function get($amount = 20, $page = 1) {

        $qb = $this->recentlySoldAxieRepo->createQueryBuilder('r');
        $qb
            ->andWhere('r.priceUsd > :minPrice')
            ->setParameter('minPrice', 800)
            ->setMaxResults($amount)
            ->orderBy('r.date', 'DESC')
            ;
        $result = $qb->getQuery()->getResult();

        $recentlySold = array_map([$this, 'serialize'], $result);

        $output = [
            '$recentlySold' => $recentlySold
        ];

        return $output;

    }

    public function crawl(SymfonyStyle $io = null) {
        $this->io = $io;
        $output = [];
        $newAxies = [];
        $qualifiedRecentlySold = [];
        $qualifiedRecentlySoldCount = 0;
        $jsonPayload = '{"operationName":"GetRecentlyAxiesSold","variables":{"from":0,"size":100,"sort":"Latest","auctionType":"Sale"},"query":"query GetRecentlyAxiesSold($from: Int, $size: Int) {\n  settledAuctions {\n    axies(from: $from, size: $size) {\n      total\n      results {\n        ...AxieSettledBrief\n        transferHistory {\n          ...TransferHistoryInSettledAuction\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment AxieSettledBrief on Axie {\n  id\n  name\n  image\n  class\n  breedCount\n  __typename\n}\n\nfragment TransferHistoryInSettledAuction on TransferRecords {\n  total\n  results {\n    ...TransferRecordInSettledAuction\n    __typename\n  }\n  __typename\n}\n\nfragment TransferRecordInSettledAuction on TransferRecord {\n  from\n  to\n  txHash\n  timestamp\n  withPrice\n  withPriceUsd\n  fromProfile {\n    name\n    __typename\n  }\n  toProfile {\n    name\n    __typename\n  }\n  __typename\n}\n"}';

        $fetchPayload = [
            'url' => 'https://graphql-gateway.axieinfinity.com/graphql',
            'payload' => [
                'json' => json_decode($jsonPayload)
            ],
        ];
        $response = $this->httpClient->request('POST', $fetchPayload['url'], $fetchPayload['payload']);

        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            $this->log('> error: cannot even get the status code.', 'error');
            return $output;
        }

        if (200 !== $statusCode) {
            $this->log('> error: expecting 200 status code, got ' . $statusCode . ' instead.', 'error');
            return $output;
        }

        $content = $response->toArray();

        if (empty($content['data']['settledAuctions']['axies']['results'])) {
            $this->log('> error: malformed or empty response.', 'error');
            return $output;
        }

        $axieResults = $content['data']['settledAuctions']['axies']['results'];
        $this->log(count($content['data']['settledAuctions']['axies']['results']) . ' axies recently sold');

        foreach($axieResults as $axieResult) {
            if (empty($axieResult['id'])) {
                $this->log('> error: an axie has no ID???', 'error');
                continue;
            }
            if (!isset($axieResult['transferHistory']['results'][0]['withPrice'], $axieResult['transferHistory']['results'][0]['withPriceUsd'])) {
                $this->log('> error: axie: ' . $axieResult['id'] . ' has missing fields.', 'error');
                continue;
            }

            // check price if passed.
            if ( $this->getMinUsdPrice() > $axieResult['transferHistory']['results'][0]['withPriceUsd'] ) {
                $this->log('axie: ' . $axieResult['id'] . ' only costs ' . $axieResult['transferHistory']['results'][0]['withPriceUsd']);
                continue;
            }
            $createOrGet = $this->axieFactoryService->createOrGetEntity($axieResult);

            if ( true === $createOrGet['$isAdded'] ) {
                $newAxies[] = $axieResult['id'];
                $this->log('axie: ' . $axieResult['id'] . ' is a new Axie in our DB');
            } else {
                $this->log('axie: ' . $axieResult['id'] . ' already exists in our DB');
            }

            $axieEntity = $createOrGet['$axieEntity'];

            // check if this axie has been sold at the same price already for the last hour
            $ethDivisor = 1000000000000000000;
            /*
                $ethPrice = round((float) ($axie['auction']['currentPrice'] / $ethDivisor), 4);
                $usdPrice = round($axieCurrentPriceUSD, 1);
             */
            $ethPrice = round((float) $axieResult['transferHistory']['results'][0]['withPrice'] / $ethDivisor, 4);
            $usdPrice = round($axieResult['transferHistory']['results'][0]['withPriceUsd'], 2);
            $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
            $breedCount = (int) $axieResult['breedCount'];

            if ( !empty($axieResult['transferHistory']['results'][0]['timestamp']) ) {
                $dateSold = \DateTimeImmutable::createFromFormat('U', (string) $axieResult['transferHistory']['results'][0]['timestamp']);
            } else {
                $dateSold = $now;
            }
            $ago = $dateSold->modify('-1 hour');

            $hasBeenSoldRecently = $this->recentlySoldAxieRepo->hasBeenSoldBetween($axieEntity, $ethPrice, $dateSold, $ago );

            if (true === $hasBeenSoldRecently) {
                $this->log('axie: ' . $axieResult['id'] . ' has been sold already recently at the same price: ' . $ethPrice . ' between ' . $dateSold->format('Y-m-d H:i:s') . ' and ' . $ago->format('Y-m-d H:i:s') );
                continue;
            } else {
                $this->log('axie: ' . $axieResult['id'] . ' has not been sold recently at the same price: ' . $ethPrice . ' between ' . $dateSold->format('Y-m-d H:i:s') . ' and ' . $ago->format('Y-m-d H:i:s') );
            }
            $qualifiedRecentlySoldCount++;

            $recentlySold = new RecentlySoldAxie();
            $recentlySold
                ->setDate($dateSold)
                ->setAxie($axieEntity)
                ->setPriceUsd($usdPrice)
                ->setPriceEth($ethPrice)
                ->setBreedCount($breedCount)
            ;

            $axieHistory = new AxieHistory($dateSold);
            $axieHistory
                ->setAxie($axieEntity)
                ->setPriceEth($ethPrice)
                ->setPriceUsd($usdPrice)
                ->setBreedCount($breedCount)
            ;
            $this->em->persist($axieHistory);
            $this->em->persist($axieEntity);
            $this->em->persist($recentlySold);
            $this->em->flush();

            $qualifiedRecentlySold[] = $recentlySold;

        }

        if (!empty($newAxies)) {
            $this->axieDataService->processAllUnprocessed($this->io, $newAxies);
        }

        $this->log('there are ' . $qualifiedRecentlySoldCount . ' qualified recently sold and ' . count($newAxies) . ' of them are new axies added to the DB');

        /**
         * @var $recentlySold RecentlySoldAxie
         */
        foreach ($qualifiedRecentlySold as $recentlySold) {
            $parts = $recentlySold->getAxie()->getParts();
            if (empty($parts)) {
                $this->log('error: cannot get the parts of axie: ' . $recentlySold->getAxie()->getId(), 'error');
                continue;
            }
            foreach($parts as $part) {
                switch(strtolower($part->getType())):
                    case 'back':
                        if ( null !== $part->getCardAbility()) {
                            $recentlySold->setBackCard($part->getCardAbility());
                        }
                        break;
                    case 'mouth':
                        if ( null !== $part->getCardAbility()) {
                            $recentlySold->setMouthCard($part->getCardAbility());
                        }
                        break;
                    case 'horn':
                        if ( null !== $part->getCardAbility()) {
                            $recentlySold->setHornCard($part->getCardAbility());
                        }
                        break;
                    case 'tail':
                        if ( null !== $part->getCardAbility()) {
                            $recentlySold->setTailCard($part->getCardAbility());
                        }
                        break;
                endswitch;
            }

            $this->em->persist($recentlySold);
            $this->em->flush();
        }

        $output['$qualifiedRecentlySoldCount'] = $qualifiedRecentlySoldCount;
        $output['$qualifiedRecentlySold'] = $qualifiedRecentlySold;
        $output['$newAxies'] = $newAxies;

        return $output;
    }

}
