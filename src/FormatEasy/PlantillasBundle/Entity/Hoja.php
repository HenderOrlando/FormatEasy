<?php
namespace FormatEasy\PlantillasBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity(repositoryClass="FormatEasy\PlantillasBundle\Repository\HojaRepository")
 * @ORM\Table(name="hoja")
 */
class Hoja extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="boolean", nullable=false, name="orientacion")
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
     * @ORM\Column(type="string", length=2, nullable=false, name="unidad")
     */
    private $unidad;

    /** 
     * @ORM\Column(type="decimal", nullable=false, name="margen_sup", precision=4, scale=2)
     */
    private $margen_sup;

    /** 
     * @ORM\Column(type="decimal", nullable=false, name="margen_inf", precision=4, scale=2)
     */
    private $margen_inf;

    /** 
     * @ORM\Column(type="decimal", nullable=false, name="margen_izq", precision=4, scale=2)
     */
    private $margen_izq;

    /** 
     * @ORM\Column(type="decimal", nullable=false, name="margen_der", precision=4, scale=2)
     */
    private $margen_der;

    /** 
     * @ORM\OneToMany(targetEntity="FormatEasy\PlantillasBundle\Entity\Plantilla", mappedBy="Hoja")
     */
    private $Plantillas;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->Plantillas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set margen_sup
     *
     * @param float $margenSup
     * @return Hoja
     */
    public function setMargenSup($margenSup)
    {
        $this->margen_sup = $margenSup;
    
        return $this;
    }

    /**
     * Get margen_sup
     *
     * @return float 
     */
    public function getMargenSup()
    {
        return $this->margen_sup;
    }

    /**
     * Set margen_inf
     *
     * @param float $margenInf
     * @return Hoja
     */
    public function setMargenInf($margenInf)
    {
        $this->margen_inf = $margenInf;
    
        return $this;
    }

    /**
     * Get margen_inf
     *
     * @return float 
     */
    public function getMargenInf()
    {
        return $this->margen_inf;
    }

    /**
     * Set margen_izq
     *
     * @param float $margenIzq
     * @return Hoja
     */
    public function setMargenIzq($margenIzq)
    {
        $this->margen_izq = $margenIzq;
    
        return $this;
    }

    /**
     * Get margen_izq
     *
     * @return float 
     */
    public function getMargenIzq()
    {
        return $this->margen_izq;
    }

    /**
     * Set margen_der
     *
     * @param float $margenDer
     * @return Hoja
     */
    public function setMargenDer($margenDer)
    {
        $this->margen_der = $margenDer;
    
        return $this;
    }

    /**
     * Get margen_der
     *
     * @return float 
     */
    public function getMargenDer()
    {
        return $this->margen_der;
    }

    /**
     * Add Plantillas
     *
     * @param \FormatEasy\PlantillasBundle\Entity\Plantilla $plantillas
     * @return Hoja
     */
    public function addPlantilla(\FormatEasy\PlantillasBundle\Entity\Plantilla $plantillas)
    {
        $this->Plantillas[] = $plantillas;
    
        return $this;
    }

    /**
     * Remove Plantillas
     *
     * @param \FormatEasy\PlantillasBundle\Entity\Plantilla $plantillas
     */
    public function removePlantilla(\FormatEasy\PlantillasBundle\Entity\Plantilla $plantillas)
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
}