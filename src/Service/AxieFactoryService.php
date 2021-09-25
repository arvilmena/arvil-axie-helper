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
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(AxieRepository $axieRepo, EntityManagerInterface $em)
    {

        $this->axieRepo = $axieRepo;
        $this->em = $em;
    }

    public function createOrGetEntity(array $axie): array
    {

        $isAdded = false;

        $axieEntity = $this->axieRepo->find((int) $axie['id']);

        if (null === $axieEntity) {
            $axieEntity = new Axie((int) $axie['id']);
            $isAdded = true;
        }
        if (empty($axieEntity->getImageUrl()) && ! empty($axie['image'])) {
            $axieEntity->setImageUrl(trim($axie['image']));
        }

        $this->em->persist($axieEntity);
        $this->em->flush();

        return [
          '$axieEntity' => $axieEntity,
          '$isAdded' => $isAdded,
        ];

    }

}
