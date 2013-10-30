<?php
namespace FormatEasy\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="etiqueta")
 * @ORM\Entity(repositoryClass="FormatEasy\CommonBundle\Repository\EtiquetaRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_etiqueta", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_etiqueta", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class Etiqueta extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\CommonBundle\Entity\Objeto", mappedBy="etiquetas")
     */
    private $objetos;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->objetos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add objetos
     *
     * @param \FormatEasy\CommonBundle\Entity\Objeto $objetos
     * @return Etiqueta
     */
    public function addObjeto(\FormatEasy\CommonBundle\Entity\Objeto $objetos)
    {
        $this->objetos[] = $objetos;
    
        return $this;
    }

    /**
     * Remove objetos
     *
     * @param \FormatEasy\CommonBundle\Entity\Objeto $objetos
     */
    public function removeObjeto(\FormatEasy\CommonBundle\Entity\Objeto $objetos)
    {
        $this->objetos->removeElement($objetos);
    }

    /**
     * Get objetos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjetos()
    {
        return $this->objetos;
    }
        
    public function __toString() {
        return $this->getNombre();
    }
    
    public function json($json = true){
        $datos = array(
            'id'                => $this->getId(),
            'nombre'            => $this->getNombre(),
            'descripcion'       => $this->getDescripcion(),
        );
        if($json)
            return json_encode($datos);
        return $datos;
    }
}