<?php
namespace FormatEasy\PlantillasBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Table(name="plantilla_formato")
 * @ORM\Entity(repositoryClass="FormatEasy\PlantillasBundle\Repository\PlantillaFormatoRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_plantilla_formato", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_plantilla_formato", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class PlantillaFormato extends \FormatEasy\CommonBundle\Entity\Objeto
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
        $this->fechaCreado = new \DateTime();
    }
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return PlantillaFormato
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
     * @return PlantillaFormato
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
     * @return PlantillaFormato
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

    public function __toString() {
        return $this->getNombre();
    }
    
    public function json($json = true){
        $datos = array(
            'id'            => $this->getId(),
            'nombre'        => $this->getNombre(),
            'descripcion'   => $this->getDescripcion(),
            'codigo'        => $this->getCodigo(),
            'hoja'          => $this->getHoja()->json(false),
            'fechaCreado'   => $this->getFechaCreado(),
        );
        if($json)
            return json_encode($datos);
        return $datos;
    }
}