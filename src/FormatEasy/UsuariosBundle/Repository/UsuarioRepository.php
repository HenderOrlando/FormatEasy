<?php
namespace FormatEasy\UsuariosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FrmatEasyUsuariosBundle:Usuario u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}