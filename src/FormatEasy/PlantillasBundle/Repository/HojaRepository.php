<?php
namespace FormatEasy\PlantillasBundle\Repository;
use Doctrine\ORM\EntityRepository;

class HojaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyPlantillasBundle:Hoja u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}