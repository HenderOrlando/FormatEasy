<?php
namespace FormatEasy\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class FormatoRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyFormatosBundle:Formato u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}