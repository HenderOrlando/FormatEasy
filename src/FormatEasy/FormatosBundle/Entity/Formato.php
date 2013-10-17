<?php
namespace FormatEasy\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Table(name="formato")
 * @ORM\Entity(repositoryClass="FormatEasy\FormatosBundle\Repository\FormatoRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_formato", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_formato", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class Formato extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(
     *     targetEntity="FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato", 
     *     mappedBy="formato"
     * )
     */
    private $usuariosFormato;

    /** 
     * @ORM\OneToMany(targetEntity="FormatEasy\FormatosBundle\Entity\PreguntaFormato", mappedBy="formato")
     */
    private $preguntas;

    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\PlantillasBundle\Entity\PlantillaPregunta", inversedBy="formatos")
     * @ORM\JoinColumn(name="plantillaPreguntas", referencedColumnName="id", nullable=false)
     */
    private $plantillaPreguntas;

    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\PlantillasBundle\Entity\PlantillaFormato", inversedBy="Formatos")
     * @ORM\JoinColumn(name="plantillaFormato", referencedColumnName="id", nullable=false)
     */
    private $PlantillaFormato;
    
    /** 
     * @ORM\Column(type="decimal", nullable=true, name="margen_sup", precision=4, scale=2, options={"default" = 4})
     */
    private $margen_sup;

    /** 
     * @ORM\Column(type="decimal", nullable=true, name="margen_inf", precision=4, scale=2, options={"default" = 2.5})
     */
    private $margen_inf;

    /** 
     * @ORM\Column(type="decimal", nullable=true, name="margen_izq", precision=4, scale=2, options={"default" = 4})
     */
    private $margen_izq;

    /** 
     * @ORM\Column(type="decimal", nullable=true, name="margen_der", precision=4, scale=2, options={"default" = 2.5})
     */
    private $margen_der;
    
    /** 
     * @ORM\Column(type="string", length=3, nullable=true, name="unidad_margen", options={"default"= "cm"})
     */
    private $unidadMargen;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->usuariosFormato = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->margen_der = 2.5;
        $this->margen_inf = 2.5;
        $this->margen_izq = 4;
        $this->margen_sup = 4;
        $this->unidadMargen = 'cm';
    }
    
    /**
     * Add usuariosFormato
     *
     * @param \FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $usuariosFormato
     * @return Formato
     */
    public function addUsuariosFormato(\FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $usuariosFormato)
    {
        $this->usuariosFormato[] = $usuariosFormato;
    
        return $this;
    }

    /**
     * Remove usuariosFormato
     *
     * @param \FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $usuariosFormato
     */
    public function removeUsuariosFormato(\FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $usuariosFormato)
    {
        $this->usuariosFormato->removeElement($usuariosFormato);
    }

    /**
     * Get usuariosFormato
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuariosFormato()
    {
        return $this->usuariosFormato;
    }

    /**
     * Add preguntas
     *
     * @param \FormatEasy\FormatosBundle\Entity\PreguntaFormato $preguntas
     * @return Formato
     */
    public function addPregunta(\FormatEasy\FormatosBundle\Entity\PreguntaFormato $preguntas)
    {
        $this->preguntas[] = $preguntas;
    
        return $this;
    }

    /**
     * Remove preguntas
     *
     * @param \FormatEasy\FormatosBundle\Entity\PreguntaFormato $preguntas
     */
    public function removePregunta(\FormatEasy\FormatosBundle\Entity\PreguntaFormato $preguntas)
    {
        $this->preguntas->removeElement($preguntas);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    /**
     * Set plantillaPreguntas
     *
     * @param \FormatEasy\PlantillasBundle\Entity\PlantillaPregunta $plantillaPreguntas
     * @return Formato
     */
    public function setPlantillaPreguntas(\FormatEasy\PlantillasBundle\Entity\PlantillaPregunta $plantillaPreguntas)
    {
        $this->plantillaPreguntas = $plantillaPreguntas;
    
        return $this;
    }

    /**
     * Get plantillaPreguntas
     *
     * @return \FormatEasy\PlantillasBundle\Entity\PlantillaPregunta 
     */
    public function getPlantillaPreguntas()
    {
        return $this->plantillaPreguntas;
    }

    /**
     * Set PlantillaFormato
     *
     * @param \FormatEasy\PlantillasBundle\Entity\PlantillaFormato $plantillaFormato
     * @return Formato
     */
    public function setPlantillaFormato(\FormatEasy\PlantillasBundle\Entity\PlantillaFormato $plantillaFormato)
    {
        $this->PlantillaFormato = $plantillaFormato;
    
        return $this;
    }

    /**
     * Get PlantillaFormato
     *
     * @return \FormatEasy\PlantillasBundle\Entity\PlantillaFormato 
     */
    public function getPlantillaFormato()
    {
        return $this->PlantillaFormato;
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
     * Set margen_der
     *
     * @param float $margenDer
     * @return Hoja
     */
    public function setUnidadMargen($unidadMargen)
    {
        $this->unidadMargen = $unidadMargen;
    
        return $this;
    }
    /**
     * Get unidad_margen
     *
     * @return string
     */
    public function getUnidadMargen()
    {
        return $this->unidadMargen;
    }
    
    public function __toString() {
        return $this->getNombre();
    }
    
    public function json($json = true){
        $datos = array(
            'id'                => $this->getId(),
            'nombre'            => $this->getNombre(),
            'descripcion'       => $this->getDescripcion(),
            'margen_der'        => $this->getMargenDer(),
            'margen_inf'        => $this->getMargenInf(),
            'margen_izq'        => $this->getMargenIzq(),
            'margen_sup'        => $this->getMargenSup(),
            'plantillaFormato'  => $this->getPlantillaFormato()->json(false),
            'plantillaPreguntas'=> $this->getPlantillaPreguntas()->json(false),
            'unidad_margen'     => $this->getUnidadMargen(),
        );
        if($json)
            return json_encode($datos);
        return $datos;
    }
}