<?php
namespace FormatEasy\PlantillasBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PlantillaRespuestaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyPlantillasBundle:PlantillaRespuesta u ORDER BY u.nombre ASC'
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
    public function getOneByWithEtiquetas($var, $etiquetas){
        return $this->getAllWithEtiquetas($var, $etiquetas, true);
    }
    public function getAllWithEtiquetas($var = array(), $etiquetas = array(), $first = false){
        $q = $this->createQueryBuilder('pr');
        foreach( $var as $id => $val ){
            $q->andWhere('pr.'.$id.'='.$val);
        }
        $q->innerJoin('pr.etiquetas', 'e');
        foreach( $etiquetas as $e ){
            $q->AndWhere("e.nombre LIKE '%".$e."%' OR e.canonical LIKE '%".$e."%'");
        }
        $query = $q->getQuery();
        if($first){
            try{
                return $query->setMaxResults(1)
                    ->getSingleResult();
            }catch (\Doctrine\ORM\NoResultException $e){
                return array(
                    'dql' => $q->getQuery ()->getDQL (),
                    'sql' => $q->getQuery ()->getSQL (),
                );
            }
        }
        $e = $query->execute();
        if(!$e)
            return array(
                'dql' => $q->getQuery ()->getDQL (),
                'sql' => $q->getQuery ()->getSQL (),
                'result' => $e,
            );
        return $e;
    }
}