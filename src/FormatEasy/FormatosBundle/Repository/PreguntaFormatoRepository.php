<?php
namespace FormatEasy\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PreguntaFormatoRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM FormatEasyFormatosBundle:PreguntaFormato u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
    public function getGreaterEqualTo($var, $order = array(), $etiquetas = array()){
        $q = $this->createQueryBuilder('p')
//                ->from('FormatEasyFormatosBundle:PreguntaFormato', 'p')
//                ->select('p.id, p.orden')
                ;
        foreach( $var as $id => $val ){
            $q->andWhere('p.'.$id.' >= '.$val);
        }
        foreach( $order as $id => $val ){
            $q->addOrderBy('p.'.$id, $val);
        }
        if(!empty($etiquetas) && !is_null($etiquetas)){
            $q->innerJoin('p.PlantillaRespuesta', 'pr');
            $q->innerJoin('pr.etiquetas', 'e');
            if (is_array($etiquetas))
                foreach( $etiquetas as $e ){
                    $q->AndWhere("e.nombre LIKE '%".$e."%' OR e.canonical LIKE '%".$e."%'");
                }
            elseif(is_string($etiquetas))
                $q->AndWhere("e.nombre LIKE '%".$etiquetas."%' OR e.canonical LIKE '%".$etiquetas."%'");
        }
        return $q->getQuery()->execute();
    }
    
    public function getOneByWithEtiquetas($var, $etiquetas){
        $q = $this->createQueryBuilder('pf')
//                ->from('FormatEasyFormatosBundle:PreguntaFormato', 'p')
//                ->select('pf.id, pf.orden, pf.nombre, pf.canonical')
                ;
        foreach( $var as $id => $val ){
            $q->andWhere('pf.'.$id.'='.$val);
        }
        $q->innerJoin('pf.PlantillaRespuesta', 'pr');
        $q->innerJoin('pr.etiquetas', 'e');
        foreach( $etiquetas as $e ){
            $q->AndWhere("e.nombre LIKE '%".$e."%' OR e.canonical LIKE '%".$e."%'");
        }
        $e = $q->getQuery()->execute();
        if(!$e)
            return array(
                'dql' => $q->getQuery ()->getDQL (),
                'sql' => $q->getQuery ()->getSQL (),
                'result' => $e,
            );
        return $e[0];
    }
}