<?php
namespace FormatEasy\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="objeto")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="aplicable_a", fieldName="aplicableA", length=50, type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "Etiqueta"="FormatEasy\CommonBundle\Entity\Etiqueta",
 *     "Rol"="FormatEasy\CommonBundle\Entity\Rol",
 *     "Usuario"="FormatEasy\UsuariosBundle\Entity\Usuario",
 *     "Formato"="FormatEasy\FormatosBundle\Entity\Formato",
 *     "Pregunta"="FormatEasy\FormatosBundle\Entity\Pregunta",
 *     "PreguntaFormato"="FormatEasy\FormatosBundle\Entity\PreguntaFormato",
 *     "Respuesta"="FormatEasy\FormatosBundle\Entity\Respuesta",
 *     "Plantilla"="FormatEasy\PlantillasBundle\Entity\Plantilla",
 *     "Hoja"="FormatEasy\PlantillasBundle\Entity\Hoja"
 * }
 * )
 */
class Objeto
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
     * @ORM\ManyToMany(targetEntity="FormatEasy\CommonBundle\Entity\Etiqueta", inversedBy="objetos")
     * @ORM\JoinTable(
     *     name="etiquetas_objetos", 
     *     joinColumns={@ORM\JoinColumn(name="id_objeto", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
     * )
     */
    private $etiquetas;
    /**
     * Constructor
     */
    public function __construct()
    {
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
}