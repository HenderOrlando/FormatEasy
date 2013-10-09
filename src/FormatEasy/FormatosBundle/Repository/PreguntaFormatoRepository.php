<?php
namespace FormatEasy\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PreguntaFormatoRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyFormatossBundle:PreguntaFormato u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}