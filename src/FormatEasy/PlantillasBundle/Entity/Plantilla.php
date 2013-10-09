<?php
namespace FormatEasy\PlantillasBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="plantilla")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="_aplicable_a", fieldName="_aplicableA", length=50, type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "Plantilla"="FormatEasy\PlantillasBundle\Entity\Plantilla",
 *     "Pregunta"="FormatEasy\PlantillasBundle\Entity\PlantillaPregunta",
 *     "Respuesta"="FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta"
 * })
 * @ORM\Entity(repositoryClass="FormatEasy\PlantillasBundle\Repository\PlantillaRepository")
 */
class Plantilla extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="text", nullable=false, name="codigo")
     */
    private $codigo;

    /** 
     * @ORM\OneToMany(targetEntity="FormatEasy\FormatosBundle\Entity\Formato", mappedBy="PlantillaFormato")
     */
    private $Formatos;

    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\PlantillasBundle\Entity\Hoja", inversedBy="Plantillas")
     * @ORM\JoinColumn(name="hoja", referencedColumnName="id", nullable=false)
     */
    private $Hoja;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->Formatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Plantilla
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Add Formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $formatos
     * @return Plantilla
     */
    public function addFormato(\FormatEasy\FormatosBundle\Entity\Formato $formatos)
    {
        $this->Formatos[] = $formatos;
    
        return $this;
    }

    /**
     * Remove Formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $formatos
     */
    public function removeFormato(\FormatEasy\FormatosBundle\Entity\Formato $formatos)
    {
        $this->Formatos->removeElement($formatos);
    }

    /**
     * Get Formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatos()
    {
        return $this->Formatos;
    }

    /**
     * Set Hoja
     *
     * @param \FormatEasy\PlantillasBundle\Entity\Hoja $hoja
     * @return Plantilla
     */
    public function setHoja(\FormatEasy\PlantillasBundle\Entity\Hoja $hoja)
    {
        $this->Hoja = $hoja;
    
        return $this;
    }

    /**
     * Get Hoja
     *
     * @return \FormatEasy\PlantillasBundle\Entity\Hoja 
     */
    public function getHoja()
    {
        return $this->Hoja;
    }
}