<?php
namespace FormatEasy\PlantillasBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PlantillaPreguntaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyPlantillasBundle:PlantillaPregunta u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}