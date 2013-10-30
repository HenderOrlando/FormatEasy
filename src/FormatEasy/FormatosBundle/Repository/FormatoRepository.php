<?php
namespace FormatEasy\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;
use FormatEasy\FormatosBundle\Entity\Formato;

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
    
    public function getPreguntasGroupByEtiquetas(Formato $f)
    {
        $em = $this->getEntityManager();
        $etiquetas = $em->getRepository('FormatEasyCommonBundle:Etiqueta')->getAllWithEtiquetas(array(),array('Diseno'));
        $array = array();
        $preguntas = clone $f->getPreguntas();
        if(!empty($etiquetas))
            foreach($etiquetas as $etiqueta){
            //Mejorar consulta
                if(in_array('Formato', $etiqueta->getTextEtiquetas(false))){
                    $array[$etiqueta->getCanonical()]['etiqueta'] = $etiqueta->getCanonical();
                    foreach ($preguntas as $id => $pf) {
                        if(in_array($etiqueta->getCanonical(), $pf->getTextEtiquetas(false))){
                            $array[$etiqueta->getCanonical()]['preguntas'][] = $pf;
                            unset($preguntas[$id]);
                        }
                    }
                }
            }
        return $array;
    }
    public function getPreguntasGroupByGrupos(Formato $f)
    {
        $firstPreguntaGrupos = $this->getPreguntasGrupo($f, -1, true);
        $preguntas = $this->getPreguntasGrupo($f, null);
        $array = array();
//        $pf = new \FormatEasy\FormatosBundle\Entity\PreguntaFormato();
        foreach ($preguntas as $pf){
            if(in_array('Formato', $pf->getPlantillaRespuesta()->getTextEtiquetas(false)))
                $array[$pf->getOrden()] = $pf;
        }
        foreach ($firstPreguntaGrupos as $pf){
            if(in_array('Formato', $pf->getPlantillaRespuesta()->getTextEtiquetas(false)))
                $array[$pf->getOrden()]['preguntas'] = $this->getPreguntasGrupo($f, $pf->getGrupo());
        }
        ksort($array);
        return $array;
    }

    public function getAllPreguntasGroupByGrupos(Formato $f, $groupBy = array('grupo','orden')) {
        $group = '';
        foreach($groupBy as $id => $g)
            if(is_string($g)){
                if($id > 0)
                    $group .= ', ';
                $group .= 'pf.'.$g;
            }
        return $this->getEntityManager()
            ->createQuery(
                'SELECT pf '.
                'FROM FormatEasyFormatosBundle:PreguntaFormato pf '.
                'WHERE pf.grupo IS NOT NULL AND pf.formato='.$f->getId().
                (empty($group)?'':'GROUP BY '.$group.' ').
                'ORDER BY pf.orden ASC '
            )
            //->getArrayResult();
            ->execute();
    }
    
    /**
     * get Preguntas Grupo
     * 
     * El parámetro $grupo puede tomar 
     *      NULL->"grupo IS NULL";
     *      < 0 ->"grupo IS NOT NULL";
     *      >=0 ->"grupo = ";
     *      TRUE->"ORDER BY grupo ASC";
     *      FALSE->"ORDER BY grupo DESC";
     * 
     * @param Integer $grupo
     * @param \FormatEasy\FormatosBundle\Entity\Formato $f
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreguntasGrupo(Formato $f = null, $grupo = -1, $onlyFirst = false) {
        $q = $this->getEntityManager()->createQueryBuilder()
                ->select('pf')
                ->from('FormatEasyFormatosBundle:PreguntaFormato', 'pf');
        if(is_bool($grupo)){
            if($grupo)
                $q->addOrderBy('pf.grupo', 'ASC');
            else
                $q->addOrderBy('pf.grupo', 'DESC');
        }
        elseif(is_null($grupo)){
            $q->andWhere('pf.grupo IS NULL');
        }elseif($grupo < 0){
            $q->andWhere('pf.grupo IS NOT NULL')
              ->addOrderBy('pf.grupo', 'ASC');
        }else{
            $q->andWhere('pf.grupo = '.$grupo);
        }
        if(!is_null($f))
            $q->andWhere('pf.formato = '.$f->getId());
        if($onlyFirst)
            $q->groupBy('pf.grupo');
        $q->addOrderBy('pf.orden', 'ASC');
        if(is_null($onlyFirst))
            return $q->getQuery ()->getArrayResult ();
        return $q->getQuery()->execute();
    }
}