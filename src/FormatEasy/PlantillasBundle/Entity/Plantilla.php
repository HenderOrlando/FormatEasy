<?php
namespace FormatEasy\PlantillasBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity(repositoryClass="FormatEasy\PlantillasBundle\Repository\PlantillaRepository")
 * @ORM\Table(name="plantilla")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="plantilla_tipo", length=50, type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "Plantilla"="Plantilla",
 *     "Pregunta"="FormatEasy\PlantillasBundle\Entity\PlantillaPregunta",
 *     "Respuesta"="FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta"
 * })
 */
class Plantilla
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=100, nullable=true, name="nombre")
     */
    private $nombre;

    /** 
     * @ORM\Column(type="string", length=100, nullable=true, name="canonical")
     */
    private $canonical;

    /** 
     * @ORM\Column(type="text", nullable=true, name="descripcion")
     */
    private $descripcion;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;

    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\CommonBundle\Entity\Etiqueta", inversedBy="plantillas")
     * @ORM\JoinTable(
     *     name="etiquetas_plantillas", 
     *     joinColumns={@ORM\JoinColumn(name="id_plantilla", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
     * )
     */
    private $etiquetas;
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
        $this->Formatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fechaCreado = new \DateTime();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Objeto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set canonical
     *
     * @param string $canonical
     * @return Objeto
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    
        return $this;
    }

    /**
     * Get canonical
     *
     * @return string 
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Objeto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return Objeto
     */
    public function setFechaCreado($fechaCreado)
    {
        $this->fechaCreado = $fechaCreado;
    
        return $this;
    }

    /**
     * Get fechaCreado
     *
     * @return \DateTime 
     */
    public function getFechaCreado()
    {
        return $this->fechaCreado;
    }

    /**
     * Add etiquetas
     *
     * @param \FormatEasy\CommonBundle\Entity\Etiqueta $etiquetas
     * @return Objeto
     */
    public function addEtiqueta(\FormatEasy\CommonBundle\Entity\Etiqueta $etiquetas)
    {
        $this->etiquetas[] = $etiquetas;
    
        return $this;
    }

    /**
     * Remove etiquetas
     *
     * @param \FormatEasy\CommonBundle\Entity\Etiqueta $etiquetas
     */
    public function removeEtiqueta(\FormatEasy\CommonBundle\Entity\Etiqueta $etiquetas)
    {
        $this->etiquetas->removeElement($etiquetas);
    }

    /**
     * Get etiquetas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEtiquetas()
    {
        return $this->etiquetas;
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