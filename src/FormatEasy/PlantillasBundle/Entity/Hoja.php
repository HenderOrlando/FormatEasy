<?php
namespace FormatEasy\PlantillasBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Table(name="hoja")
 * @ORM\Entity(repositoryClass="FormatEasy\PlantillasBundle\Repository\HojaRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_hoja", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_hoja", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class Hoja extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="boolean", nullable=true, name="orientacion", options={"default" = 0})
     */
    private $orientacion;

    /** 
     * @ORM\Column(type="decimal", length=5, nullable=false, name="ancho", precision=6, scale=3)
     */
    private $ancho;

    /** 
     * @ORM\Column(type="decimal", nullable=false, name="alto", precision=6, scale=3)
     */
    private $alto;

    /** 
     * @ORM\Column(type="string", length=2, nullable=false, name="unidad", options={"default" = "mm"})
     */
    private $unidad;

    /** 
     * @ORM\OneToMany(targetEntity="FormatEasy\PlantillasBundle\Entity\PlantillaFormato", mappedBy="Hoja")
     */
    private $Plantillas;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->Plantillas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unidad = 'mm';
        $this->orientacion = 0;
    }
    
    /**
     * Set orientacion
     *
     * @param boolean $orientacion
     * @return Hoja
     */
    public function setOrientacion($orientacion)
    {
        $this->orientacion = $orientacion;
    
        return $this;
    }

    /**
     * Get orientacion
     *
     * @return boolean 
     */
    public function getOrientacion()
    {
        return $this->orientacion;
    }
    
    /**
     * Get orientacion text
     *
     * @return boolean 
     */
    public function getOrientacionText()
    {
        return $this->orientacion?'Horizontal':'Vertical';
    }

    /**
     * Set ancho
     *
     * @param float $ancho
     * @return Hoja
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;
    
        return $this;
    }

    /**
     * Get ancho
     *
     * @return float 
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set alto
     *
     * @param float $alto
     * @return Hoja
     */
    public function setAlto($alto)
    {
        $this->alto = $alto;
    
        return $this;
    }

    /**
     * Get alto
     *
     * @return float 
     */
    public function getAlto()
    {
        return $this->alto;
    }

    /**
     * Set unidad
     *
     * @param string $unidad
     * @return Hoja
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;
    
        return $this;
    }

    /**
     * Get unidad
     *
     * @return string 
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Add Plantillas
     *
     * @param \FormatEasy\PlantillasBundle\Entity\PlantillaFormato $plantillas
     * @return Hoja
     */
    public function addPlantilla(\FormatEasy\PlantillasBundle\Entity\PlantillaFormato $plantillas)
    {
        $this->Plantillas[] = $plantillas;
    
        return $this;
    }

    /**
     * Remove Plantillas
     *
     * @param \FormatEasy\PlantillasBundle\Entity\PlantillaFormato $plantillas
     */
    public function removePlantilla(\FormatEasy\PlantillasBundle\Entity\PlantillaFormato $plantillas)
    {
        $this->Plantillas->removeElement($plantillas);
    }

    /**
     * Get Plantillas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlantillas()
    {
        return $this->Plantillas;
    }
    
    public function __toString() {
        return $this->getNombre();
    }
    
    public function json($json = true){
        $datos = array(
            'id'            => $this->getId(),
            'nombre'        => $this->getNombre(),
            'descripcion'   => $this->getDescripcion(),
            'alto'          => $this->getAlto(),
            'ancho'         => $this->getAncho(),
            'orientacion'   => $this->getOrientacion(),
            'unidad'        => $this->getUnidad(),
            'fechaCreado'   => $this->getFechaCreado(),
        );
        if($json)
            return json_encode($datos);
        return $datos;
    }
}