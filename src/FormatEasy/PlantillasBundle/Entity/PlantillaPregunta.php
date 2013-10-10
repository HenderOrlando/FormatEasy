<?php
namespace FormatEasy\PlantillasBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity(repositoryClass="FormatEasy\PlantillasBundle\Repository\PlantillaPreguntaRepository")
 * @ORM\Table(name="plantilla_pregunta")
 */
class PlantillaPregunta extends Plantilla
{
    /** 
     * @ORM\OneToMany(targetEntity="FormatEasy\FormatosBundle\Entity\Formato", mappedBy="plantillaPreguntas")
     */
    private $formatos;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $formatos
     * @return PlantillaPregunta
     */
    public function addFormato(\FormatEasy\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatos[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $formatos
     */
    public function removeFormato(\FormatEasy\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatos->removeElement($formatos);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatos()
    {
        return $this->formatos;
    }
}