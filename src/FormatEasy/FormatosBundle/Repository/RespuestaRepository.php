<?php
namespace FormatEasy\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class RespuestaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyFormatosBundle:Respuesta u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}