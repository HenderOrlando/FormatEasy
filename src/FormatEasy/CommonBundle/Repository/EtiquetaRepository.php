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
    
    public function getOneEtiqueta($etiquetas = array()){
        if(!empty($etiquetas)){
            $q = $this->createQueryBuilder('e');
            foreach($etiquetas as $e)
                if(is_string($e))
                    $q->andWhere ("e.canonical LIKE '%".$e."%' OR e.nombre LIKE '%".$e."%'");
        }
        $r = $q->getQuery()->execute();
        return $r[0];
    }
    
    public function getOneByWithEtiquetas($var, $etiquetas){
        return $this->getAllWithEtiquetas($var, $etiquetas, true);
    }
    public function getAllWithEtiquetas($var = array(), $etiquetas = array(), $first = false){
        $q = $this->createQueryBuilder('pr')
                /*->select('pr.nombre, pr.canonical, pr.descripcion, pr.fechaCreado, pr.id')*/;
        foreach( $var as $id => $val ){
            $q->andWhere('pr.'.$id.'='.$val);
        }
        $q->innerJoin('pr.etiquetas', 'e');
        foreach( $etiquetas as $e ){
            //No funciona con varias etiquetas
            $q->OrWhere("e.nombre LIKE '%".$e."%' OR e.canonical LIKE '%".$e."%'");
        }
        $query = $q->getQuery();
        if($first){
            try{
                $rta = $query->setMaxResults(1)->getResult();
                return $rta[0];
            }catch (\Doctrine\ORM\NoResultException $e){
                return array(
                    'dql' => $q->getQuery ()->getDQL (),
                    'sql' => $q->getQuery ()->getSQL (),
                );
            }
        }
        $e = $query->getResult();
        if(!$e)
            return array(
                'dql' => $q->getQuery ()->getDQL (),
                'sql' => $q->getQuery ()->getSQL (),
                'result' => $e,
            );
        return $e;
    }
}