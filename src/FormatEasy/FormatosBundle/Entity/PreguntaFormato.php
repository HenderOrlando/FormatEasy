<?php
namespace FormatEasy\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="pregunta_formato")
 * @ORM\Entity(repositoryClass="FormatEasy\FormatosBundle\Repository\PreguntaFormatoRepository")
 */
class PreguntaFormato extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="smallint", nullable=false, name="orden")
     */
    private $orden;

    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\FormatosBundle\Entity\Formato", inversedBy="preguntas")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;

    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\FormatosBundle\Entity\Pregunta", inversedBy="formatos")
     * @ORM\JoinColumn(name="pregunta", referencedColumnName="id", nullable=false)
     */
    private $pregunta;

    /** 
     * @ORM\ManyToOne(
     *     targetEntity="FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta", 
     *     inversedBy="PreguntaFormatos"
     * )
     * @ORM\JoinColumn(name="plantillaRespuesta", referencedColumnName="id", nullable=false)
     */
    private $PlantillaRespuesta;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return PreguntaFormato
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    
        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set formato
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $formato
     * @return PreguntaFormato
     */
    public function setFormato(\FormatEasy\FormatosBundle\Entity\Formato $formato)
    {
        $this->formato = $formato;
    
        return $this;
    }

    /**
     * Get formato
     *
     * @return \FormatEasy\FormatosBundle\Entity\Formato 
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Set pregunta
     *
     * @param \FormatEasy\FormatosBundle\Entity\Pregunta $pregunta
     * @return PreguntaFormato
     */
    public function setPregunta(\FormatEasy\FormatosBundle\Entity\Pregunta $pregunta)
    {
        $this->pregunta = $pregunta;
    
        return $this;
    }

    /**
     * Get pregunta
     *
     * @return \FormatEasy\FormatosBundle\Entity\Pregunta 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set PlantillaRespuesta
     *
     * @param \FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta $plantillaRespuesta
     * @return PreguntaFormato
     */
    public function setPlantillaRespuesta(\FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta $plantillaRespuesta)
    {
        $this->PlantillaRespuesta = $plantillaRespuesta;
    
        return $this;
    }

    /**
     * Get PlantillaRespuesta
     *
     * @return \FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta 
     */
    public function getPlantillaRespuesta()
    {
        return $this->PlantillaRespuesta;
    }
}