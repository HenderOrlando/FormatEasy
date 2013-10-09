<?php
namespace FormatEasy\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;

class EtiquetaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyCommonBundle:Etiqueta u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}