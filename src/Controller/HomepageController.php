<?php

namespace App\Controller;

use App\Entity\AxieGenes;
use App\Entity\MarketplaceCrawl;
use App\Repository\AxieRepository;
use App\Repository\MarketplaceCrawlRepository;
use App\Service\CrawlMarketplaceWatchlistService;
use App\Service\NotifyService;
use App\Service\RecentlySoldAxieService;
use App\Util\AxieGeneUtil;
use BCMathExtended\BC;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class HomepageController extends AbstractController
{

    /**
     * @var CrawlMarketplaceWatchlistService
     */
    private $crawlMarketplaceWatchlistService;
    /**
     * @var MarketplaceCrawlRepository
     */
    private $marketplaceCrawlRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Serializer
     */
    private $serializer;
    /**
     * @var RecentlySoldAxieService
     */
    private $recentlySoldAxieService;

    public function __construct(CrawlMarketplaceWatchlistService $crawlMarketplaceWatchlistService, MarketplaceCrawlRepository $marketplaceCrawlRepo, EntityManagerInterface $em, SerializerInterface $serializer, RecentlySoldAxieService $recentlySoldAxieService) {

        $this->crawlMarketplaceWatchlistService = $crawlMarketplaceWatchlistService;
        $this->marketplaceCrawlRepo = $marketplaceCrawlRepo;
        $this->em = $em;

        $this->serializer = $serializer;
        $this->recentlySoldAxieService = $recentlySoldAxieService;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {

        $context = [];
        $context['recentlySold']['all']['recent'] = $this->recentlySoldAxieService->get();

        foreach([
            'aquatic',
            'beast',
            'bird',
            'bug',
            'dawn',
            'dusk',
            'mech',
            'plant',
            'reptile'] as $axieClass) {

            $context['recentlySold'][$axieClass]['recent'] = $this->recentlySoldAxieService->get($axieClass);
            $context['recentlySold'][$axieClass]['most-expensive'] = $this->recentlySoldAxieService->get($axieClass, 'most-expensive');
        }

        return $this->render('homepage/index.html.twig', $context);
    }

    /**
     * @Route("/email-test", name="emailTest")
     */
    public function emailTest(NotifyService $notifyService):Response {
        return $this->json($notifyService->test('hey'));
    }

    /**
     * @Route("/test2", name="test2")
     */
    public function test2(AxieRepository $axieRepository) : Response {
        $output = [];

        $axieEntity = $axieRepository->find(368007);

        $dominantGenes = $axieEntity->getGenes()->filter(function(AxieGenes $ag) {
            return trim(strtolower((string) $ag->getGeneType())) === 'd';
        });

        var_dump($dominantGenes->toArray());

        $numberOfCardAbilities= 0;
        $avgAttackPerCard = 0;
        $avgDefencePerCard = 0;
        foreach($dominantGenes as $dominantGene) {
            $partEntity = $dominantGene->getPart();
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
        }
        var_dump('$numberOfCardAbilities',$numberOfCardAbilities);
        $output['$numberOfCardAbilities'] = $numberOfCardAbilities;

        return $this->json($output);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        $output = [];

        $axieData = <<<JSON
{"data":{"axie":{"id":"1199226","image":"https://storage.googleapis.com/assets.axieinfinity.com/axies/1199226/axie/axie-full-transparent.png","class":"Beast","chain":"ronin","name":"Axie #1199226","genes":"0x820140300a3100a00a4200400200802004010040020080200c31886","owner":"0x0e9fd1f001bf4e02e58ee147b366aeb05b60a3f8","birthDate":1624916745,"bodyShape":"Normal","sireId":1018763,"sireClass":"Beast","matronId":994581,"matronClass":"Beast","stage":4,"title":"","breedCount":3,"level":1,"figure":{"atlas":"https://storage.googleapis.com/assets.axieinfinity.com/axies/1199226/axie/axie.atlas","model":"https://storage.googleapis.com/assets.axieinfinity.com/axies/1199226/axie/axie.json","image":"https://storage.googleapis.com/assets.axieinfinity.com/axies/1199226/axie/axie.png","__typename":"AxieFigure"},"parts":[{"id":"eyes-chubby","name":"Chubby","class":"Beast","type":"Eyes","specialGenes":null,"stage":1,"abilities":[],"__typename":"AxiePart"},{"id":"ears-nyan","name":"Nyan","class":"Beast","type":"Ears","specialGenes":null,"stage":1,"abilities":[],"__typename":"AxiePart"},{"id":"back-ronin","name":"Ronin","class":"Beast","type":"Back","specialGenes":null,"stage":1,"abilities":[{"id":"beast-back-02","name":"Single Combat","attack":75,"defense":0,"energy":1,"description":"Guaranteed critical strike when comboed with at least 2 other cards.","backgroundUrl":"https://storage.googleapis.com/axie-cdn/game/cards/base/beast-back-02.png","effectIconUrl":"https://storage.googleapis.com/axie-cdn/game/cards/effect-icons/critical.png","__typename":"AxieCardAbility"}],"__typename":"AxiePart"},{"id":"mouth-confident","name":"Confident","class":"Beast","type":"Mouth","specialGenes":null,"stage":1,"abilities":[{"id":"beast-mouth-10","name":"Self Rally","attack":0,"defense":30,"energy":0,"description":"Apply 2 Morale+ to this Axie for 2 rounds.","backgroundUrl":"https://storage.googleapis.com/axie-cdn/game/cards/base/beast-mouth-10.png","effectIconUrl":"https://storage.googleapis.com/axie-cdn/game/cards/effect-icons/morale-up.png","__typename":"AxieCardAbility"}],"__typename":"AxiePart"},{"id":"horn-imp","name":"Imp","class":"Beast","type":"Horn","specialGenes":null,"stage":1,"abilities":[{"id":"beast-horn-04","name":"Ivory Stab","attack":70,"defense":20,"energy":1,"description":"Gain 1 energy per critical strike dealt by your team this round.","backgroundUrl":"https://storage.googleapis.com/axie-cdn/game/cards/base/beast-horn-04.png","effectIconUrl":"https://storage.googleapis.com/axie-cdn/game/cards/effect-icons/gain-energy.png","__typename":"AxieCardAbility"}],"__typename":"AxiePart"},{"id":"tail-gerbil","name":"Gerbil","class":"Beast","type":"Tail","specialGenes":null,"stage":1,"abilities":[{"id":"beast-tail-12","name":"Gerbil Jump","attack":40,"defense":20,"energy":1,"description":"Skip the closest target if there are 2 or more enemies remaining.","backgroundUrl":"https://storage.googleapis.com/axie-cdn/game/cards/base/beast-tail-12.png","effectIconUrl":"https://storage.googleapis.com/axie-cdn/game/cards/effect-icons/prioritize.png","__typename":"AxieCardAbility"}],"__typename":"AxiePart"}],"stats":{"hp":31,"speed":41,"skill":31,"morale":61,"__typename":"AxieStats"},"auction":{"startingPrice":"200000000000000000","endingPrice":"145000000000000000","startingTimestamp":"1625359803","endingTimestamp":"1625446203","duration":"86400","timeLeft":"0","currentPrice":"145000000000000000","currentPriceUSD":"395.45","suggestedPrice":"145000000000000000","seller":"0x5792c42bce928ab08ce20a2eb81a87903389ae0d","listingIndex":544013,"state":"47060262009505509337859606159184138593734573437024097745338025813687603625713","__typename":"Auction"},"ownerProfile":{"name":"AGA Scholar 15","__typename":"PublicProfile"},"battleInfo":{"banned":false,"banUntil":null,"level":0,"__typename":"AxieBattleInfo"},"children":[{"id":"1462465","name":"Axie #1462465","class":"Beast","image":"https://storage.googleapis.com/assets.axieinfinity.com/axies/1462465/axie/axie-full-transparent.png","title":"","stage":4,"__typename":"Axie"},{"id":"1462501","name":"12","class":"Beast","image":"https://storage.googleapis.com/assets.axieinfinity.com/axies/1462501/axie/axie-full-transparent.png","title":"","stage":4,"__typename":"Axie"},{"id":"1462453","name":"DONT SELL- Gotchya","class":"Beast","image":"https://storage.googleapis.com/assets.axieinfinity.com/axies/1462453/axie/axie-full-transparent.png","title":"","stage":4,"__typename":"Axie"}],"__typename":"Axie"}}}
JSON;

        $axieData = json_decode($axieData, true);

        $geneData = new AxieGeneUtil($axieData['data']['axie']['genes']);

        $output['traits'] = $geneData->getTraits();
        $output['dominantTraits'] = $geneData->getDominantGenes();
        $output['r1Traits'] = $geneData->getR1Genes();
        $output['r2Traits'] = $geneData->getR2Genes();
        $output['getAllGenes'] = $geneData->getAllGenes();
        $output['getDominantClassPurity'] = $geneData->getDominantClassPurity();
        $output['getR1ClassPurity'] = $geneData->getR1ClassPurity();
        $output['getR2ClassPurity'] = $geneData->getR2ClassPurity();
        $output['getOverallClassPurity'] = $geneData->getOverallClassPurity();
        $output['getDominantClasses'] = $geneData->getDominantClasses();
        $output['countDominantClasses'] = $geneData->countDominantClasses();
        $output['getR1Classes'] = $geneData->getR1Classes();
        $output['countR1Classes'] = $geneData->countR1Classes();
        $output['getR2Classes'] = $geneData->getR2Classes();
        $output['countR2Classes'] = $geneData->countR2Classes();
        $output['getQuality'] = $geneData->getQuality();
        $output['getPureness'] = $geneData->getPureness();
        $output['getGenePassingRates'] = $geneData->getGenePassingRates();


        return new Response($this->serializer->serialize($output, 'json'));

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
