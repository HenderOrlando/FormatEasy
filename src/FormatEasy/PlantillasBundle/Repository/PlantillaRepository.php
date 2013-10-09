<?php
namespace FormatEasy\PlantillasBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PlantillaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyPlantillasBundle:Plantilla u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}