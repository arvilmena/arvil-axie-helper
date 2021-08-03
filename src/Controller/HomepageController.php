<?php

namespace App\Controller;

use App\Entity\MarketplaceCrawl;
use App\Repository\MarketplaceCrawlRepository;
use App\Service\CrawlMarketplaceWatchlistService;
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

    public function __construct(CrawlMarketplaceWatchlistService $crawlMarketplaceWatchlistService, MarketplaceCrawlRepository $marketplaceCrawlRepo, EntityManagerInterface $em, SerializerInterface $serializer) {

        $this->crawlMarketplaceWatchlistService = $crawlMarketplaceWatchlistService;
        $this->marketplaceCrawlRepo = $marketplaceCrawlRepo;
        $this->em = $em;

        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
//        $this->crawlMarketplaceWatchlistService->crawlAll();

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        $output = [];

        $axieData = <<<JSON
{
  "data": {
    "axie": {
      "id": "2114909",
      "image": "https://storage.googleapis.com/assets.axieinfinity.com/axies/2114909/axie/axie-full-transparent.png",
      "class": "Beast",
      "chain": "ronin",
      "name": "Axie #2114909",
      "genes": "0x610442400200948002008020040100400a0280a0085290400802844",
      "owner": "0x98d5b7aebbaa22a3244273da91f894c352a90004",
      "birthDate": 1626262476,
      "bodyShape": "Normal",
      "sireId": 1748604,
      "sireClass": "Beast",
      "matronId": 1750377,
      "matronClass": "Beast",
      "stage": 4,
      "title": "",
      "breedCount": 2,
      "level": 1,
      "figure": {
        "atlas": "https://storage.googleapis.com/assets.axieinfinity.com/axies/2114909/axie/axie.atlas",
        "model": "https://storage.googleapis.com/assets.axieinfinity.com/axies/2114909/axie/axie.json",
        "image": "https://storage.googleapis.com/assets.axieinfinity.com/axies/2114909/axie/axie.png",
        "__typename": "AxieFigure"
      },
      "parts": [
        {
          "id": "eyes-zeal",
          "name": "Zeal",
          "class": "Beast",
          "type": "Eyes",
          "specialGenes": null,
          "stage": 1,
          "abilities": [],
          "__typename": "AxiePart"
        },
        {
          "id": "ears-nut-cracker",
          "name": "Nut Cracker",
          "class": "Beast",
          "type": "Ears",
          "specialGenes": null,
          "stage": 1,
          "abilities": [],
          "__typename": "AxiePart"
        },
        {
          "id": "back-risky-beast",
          "name": "Risky Beast",
          "class": "Beast",
          "type": "Back",
          "specialGenes": null,
          "stage": 1,
          "abilities": [
            {
              "id": "beast-back-08",
              "name": "Revenge Arrow",
              "attack": 125,
              "defense": 25,
              "energy": 1,
              "description": "Deal 150% damage if this Axie is in Last Stand.",
              "backgroundUrl": "https://storage.googleapis.com/axie-cdn/game/cards/base/beast-back-08.png",
              "effectIconUrl": "https://storage.googleapis.com/axie-cdn/game/cards/effect-icons/raise-damage.png",
              "__typename": "AxieCardAbility"
            }
          ],
          "__typename": "AxiePart"
        },
        {
          "id": "mouth-nut-cracker",
          "name": "Nut Cracker",
          "class": "Beast",
          "type": "Mouth",
          "specialGenes": null,
          "stage": 1,
          "abilities": [
            {
              "id": "beast-mouth-02",
              "name": "Nut Crack",
              "attack": 105,
              "defense": 30,
              "energy": 1,
              "description": "Deal 120% damage when comboed with another 'Nut Cracker' card.",
              "backgroundUrl": "https://storage.googleapis.com/axie-cdn/game/cards/base/beast-mouth-02.png",
              "effectIconUrl": "https://storage.googleapis.com/axie-cdn/game/cards/effect-icons/raise-damage.png",
              "__typename": "AxieCardAbility"
            }
          ],
          "__typename": "AxiePart"
        },
        {
          "id": "horn-dual-blade",
          "name": "Dual Blade",
          "class": "Beast",
          "type": "Horn",
          "specialGenes": null,
          "stage": 1,
          "abilities": [
            {
              "id": "beast-horn-10",
              "name": "Sinister Strike",
              "attack": 130,
              "defense": 20,
              "energy": 1,
              "description": "Deal 250% damage on critical strikes.",
              "backgroundUrl": "https://storage.googleapis.com/axie-cdn/game/cards/base/beast-horn-10.png",
              "effectIconUrl": "https://storage.googleapis.com/axie-cdn/game/cards/effect-icons/raise-damage.png",
              "__typename": "AxieCardAbility"
            }
          ],
          "__typename": "AxiePart"
        },
        {
          "id": "tail-hare",
          "name": "Hare",
          "class": "Beast",
          "type": "Tail",
          "specialGenes": null,
          "stage": 1,
          "abilities": [
            {
              "id": "beast-tail-08",
              "name": "Hare Dagger",
              "attack": 120,
              "defense": 30,
              "energy": 1,
              "description": "Draw a card if this Axie attacks at the beginning of the round.",
              "backgroundUrl": "https://storage.googleapis.com/axie-cdn/game/cards/base/beast-tail-08.png",
              "effectIconUrl": "https://storage.googleapis.com/axie-cdn/game/cards/effect-icons/draw-card.png",
              "__typename": "AxieCardAbility"
            }
          ],
          "__typename": "AxiePart"
        }
      ],
      "stats": {
        "hp": 31,
        "speed": 41,
        "skill": 31,
        "morale": 61,
        "__typename": "AxieStats"
      },
      "auction": null,
      "ownerProfile": {
        "name": "snipe scholar 7",
        "__typename": "PublicProfile"
      },
      "battleInfo": {
        "banned": false,
        "banUntil": null,
        "level": 0,
        "__typename": "AxieBattleInfo"
      },
      "children": [
        {
          "id": "2503463",
          "name": "Axie #2503463",
          "class": "Beast",
          "image": "https://storage.googleapis.com/assets.axieinfinity.com/axies/2503463/axie/axie-full-transparent.png",
          "title": "",
          "stage": 4,
          "__typename": "Axie"
        },
        {
          "id": "2503453",
          "name": "Axie #2503453",
          "class": "Beast",
          "image": "https://storage.googleapis.com/assets.axieinfinity.com/axies/2503453/axie/axie-full-transparent.png",
          "title": "",
          "stage": 4,
          "__typename": "Axie"
        }
      ],
      "__typename": "Axie"
    }
  }
}
JSON;
        /*
            axies[id] = result;
            if (result.stage > 2) {
                axies[id].genes = genesToBin(BigInt(axies[id].genes));
                let traits = getTraits(axies[id].genes);
                let qp = getQualityAndPureness(traits, axies[id].class.toLowerCase());
                axies[id].traits = traits;
                axies[id].quality = qp.quality;
                axies[id].pureness = qp.pureness;
            }
         */

        $hex = '0x30000000030812220c2310c20c2308c20cc420c40ca328ca0cc330c60c2330cc';

        function base_convert_arbitrary($number, $fromBase, $toBase) {
            $digits = '0123456789abcdefghijklmnopqrstuvwxyz';
            $length = strlen($number);
            $result = '';

            $nibbles = array();
            for ($i = 0; $i < $length; ++$i) {
                $nibbles[$i] = strpos($digits, str_split($number)[$i]);
            }

            do {
                $value = 0;
                $newlen = 0;
                for ($i = 0; $i < $length; ++$i) {
                    $value = $value * $fromBase + $nibbles[$i];
                    if ($value >= $toBase) {
                        $nibbles[$newlen++] = (int)($value / $toBase);
                        $value %= $toBase;
                    }
                    else if ($newlen > 0) {
                        $nibbles[$newlen++] = 0;
                    }
                }
                $length = $newlen;
                $result = $digits[$value].$result;
            }
            while ($newlen != 0);
            return $result;
        }

        $originalHexcode = '0x810a43400a310c8004009080020214200a028c6002008020042314a';

        $bigInt = BC::hexdec($originalHexcode);

        $binary = base_convert_arbitrary($bigInt, 10, 2);

        $strMul = str_repeat("0", (256 - strlen($binary)));

        $final = $strMul . $binary;

?>

        <table>
            <tr>
                <td>Axie ID 2744481</td>
                <td>calculated</td>
                <td>expected</td>
            </tr>
            <tr>
                <td>Original Genes</td>
                <td colspan="2"><?= $originalHexcode; ?></td>
            </tr>
            <tr>
                <td>BigInt</td>
                <td><?= $bigInt; ?></td>
                <td>849344215841909609199585950172954190544722304140846169088527053130n</td>
            </tr>
            <tr>
                <td>.toString(2)</td>
                <td><?= $binary; ?></td>
                <td>1000000100001010010000110100000000001010001100010000110010000000000001000000000010010000100000000000001000000010000101000010000000001010000000101000110001100000000000100000000010000000001000000000010000100011000101001010</td>
            </tr>
            <tr>
                <td>_strMul</td>
                <td><?= $strMul; ?></td>
                <td>000000000000000000000000000000000000</td>
            </tr>
            <tr>
                <td>Final</td>
                <td><?= $final; ?></td>
                <td>0000000000000000000000000000000000001000000100001010010000110100000000001010001100010000110010000000000001000000000010010000100000000000001000000010000101000010000000001010000000101000110001100000000000100000000010000000001000000000010000100011000101001010</td>
            </tr>
        </table>

<?php


        return new Response($this->serializer->serialize($output, 'json'));

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
