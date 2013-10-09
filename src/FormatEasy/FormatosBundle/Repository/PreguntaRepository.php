<?php
namespace FormatEasy\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PreguntaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyFormatosBundle:Pregunta u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}