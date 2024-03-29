<?php
namespace FormatEasy\PlantillasBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PlantillaFormatoRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyPlantillasBundle:Plantilla u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
    
    public function findFirst()
    {
        try{
        return $this->createQueryBuilder('p')
            ->orderBy('p.id','ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->getSingleResult();
        }catch (\Doctrine\ORM\NoResultException $e){
            return null;
        }
    }
}