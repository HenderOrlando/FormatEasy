<?php
namespace FormatEasy\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UsuarioRespuestaPreguntaFormatoRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyFormatosBundle:UsuarioRespuestaPreguntaFormato u ORDER BY u.fechaCreado DESC'
            )
            ->getResult();
    }
}