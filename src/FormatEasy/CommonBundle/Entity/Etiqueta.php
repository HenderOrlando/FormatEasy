<?php
namespace FormatEasy\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="etiqueta")
 * @ORM\Entity(repositoryClass="FormatEasy\CommonBundle\Repository\EtiquetaRepository")
 */
class Etiqueta extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\CommonBundle\Entity\Objeto", mappedBy="etiquetas")
     */
    private $objetos;
    
    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\PlantillasBundle\Entity\Plantilla", mappedBy="etiquetas")
     */
    private $plantillas;
    
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
    
    /**
     * Add objetos
     *
     * @param \FormatEasy\PlantillasBundle\Entity\Plantilla $objetos
     * @return Etiqueta
     */
    public function addPlantilla(\FormatEasy\PlantillasBundle\Entity\Plantilla $objetos)
    {
        $this->objetos[] = $objetos;
    
        return $this;
    }

    /**
     * Remove objetos
     *
     * @param \FormatEasy\PlantillasBundle\Entity\Plantilla $objetos
     */
    public function removePlantilla(\FormatEasy\PlantillasBundle\Entity\Plantilla $objetos)
    {
        $this->objetos->removeElement($objetos);
    }

    /**
     * Get objetos
     *
     * @return \Doctrine\Plantillas\Collections\Collection 
     */
    public function getPlantillas()
    {
        return $this->objetos;
    }
}