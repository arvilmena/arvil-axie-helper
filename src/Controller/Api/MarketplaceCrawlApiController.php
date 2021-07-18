<?php

namespace App\Controller\Api;

use App\Entity\MarketplaceCrawl;
use App\Repository\MarketplaceCrawlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MarketplaceCrawlApiController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var MarketplaceCrawlRepository
     */
    private $mpcRepo;

    public function __construct(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        MarketplaceCrawlRepository $mpcRepo
    ){
        $this->em = $em;
        $this->serializer = $serializer;
        $this->mpcRepo = $mpcRepo;
    }

    /**
     * @Route("/api/marketplacecrawl/axie", name="api_marketplacecrawl_axie")
     */
    public function index(Request $request): Response
    {

        $response = [];

        $payload = json_decode($request->getContent(), true);

        $crawlDate = !empty($payload['crawlDate']) ? new \DateTime($payload['crawlDate']) : new \DateTime('now');
        $url = $payload['url'] ?? '';
        $baseUrl = $payload['baseUrl'] ?? null;
        $page = $payload['page'] ?? null;
        $apiResponse = $payload['apiResponse'] ?? null;
        $apiRequest = $payload['apiRequest'] ?? null;
        $crawlSessionUlid = $payload['crawlSessionUlid'] ?? null;
        $browserRequestId = $payload['browserRequestId'] ?? null;
        $statusCode = $payload['statusCode'] ?? null;

        $saved = false;
        $isDuplicate = false;
        if (!empty($apiResponse) && !empty($apiRequest)) {

            $marketPlaceCrawl = null;

            if ( ! empty($browserSession) && ! empty($browserRequestId) ) {
                $marketPlaceCrawl = $this->mpcRepo->findOneBy(
                    [ 'browserSession' => $browserSession, 'browserRequestId' =>$browserRequestId ]
                );
                $saved = true;
                $isDuplicate = true;
            }

            if (null == $marketPlaceCrawl) {
                $marketPlaceCrawl = new MarketplaceCrawl($apiRequest, $crawlDate);
                $marketPlaceCrawl->setUrl($url)
                    ->setBaseUrl($baseUrl)
                    ->setPage($page)
                    ->setResponse(json_encode($apiResponse))
                    ->setCrawlSessionUlid($crawlSessionUlid)
                    ->setBrowserRequestId($browserRequestId)
                    ->setStatusCode($statusCode)
                ;

                $this->em->persist($marketPlaceCrawl);
                $this->em->flush();
                $saved = true;
            }
        }

        $response['$crawlDate'] = $crawlDate;
        $response['$url'] = $url;
        $response['$apiResponse'] = $apiResponse;
        $response['$apiRequest'] = $apiRequest;
        $response['$browserRequestId'] = $browserRequestId;
        $response['$saved'] = $saved;
        $response['$isDuplicate'] = $isDuplicate;

        return new Response($this->serializer->serialize($response, 'json'));
    }
}
