<?php
/**
 * AxieFactoryService.php file summary.
 *
 * AxieFactoryService.php file description.
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
use App\Entity\AxieHistory;
use App\Entity\AxieRawData;
use App\Entity\CrawlResultAxie;
use App\Repository\AxieRawDataRepository;
use App\Repository\AxieRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AxieFactoryService.
 *
 * Class AxieFactoryService description.
 *
 * @since 1.0.0
 */
class AxieFactoryService
{

    /**
     * @var AxieRepository
     */
    private $axieRepo;
    /**
     * @var AxieRawDataRepository
     */
    private $axieRawDataRepo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(AxieRepository $axieRepo, AxieRawDataRepository $axieRawDataRepository, EntityManagerInterface $em)
    {

        $this->axieRepo = $axieRepo;
        $this->axieRawDataRepo = $axieRawDataRepository;
        $this->em = $em;
    }

    public function createAndGetEntity(array $axie) {

        $output = [];

        $axieEntity = $this->axieRepo->find((int) $axie['id']);

        if (null === $axieEntity) {
            $axieEntity = new Axie((int) $axie['id']);
        }
        if (empty($axieEntity->getImageUrl()) && ! empty($axie['image'])) {
            $axieEntity->setImageUrl(trim($axie['image']));
        }

        $rawDataEntity = $this->axieRawDataRepo->find($axieEntity->getId());
        if (null === $rawDataEntity) {
            $rawDataEntity = new AxieRawData($axieEntity);
        }
        $rawDataEntity->setRawDataBrief(json_encode($axie));
        $this->em->persist($rawDataEntity);
        $this->em->persist($axieEntity);
        $this->em->flush();

        $output['axiesAdded'][] = (int) $axie['id'];

        return $output;

    }

}
