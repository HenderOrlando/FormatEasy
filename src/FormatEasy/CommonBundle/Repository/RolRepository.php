<?php
namespace FormatEasy\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;

class RolRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FrmatEasyCommonBundle:Rol u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}