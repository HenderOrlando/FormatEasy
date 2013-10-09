<?php
namespace FormatEasy\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="pregunta")
 * @ORM\Entity(repositoryClass="FormatEasy\FormatosBundle\Repository\PreguntaRepository")
 */
class Pregunta extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(
     *     targetEntity="FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato", 
     *     mappedBy="pregunta"
     * )
     */
    private $preguntasUsuario;
    /** 
     * 
     */
    private $UsuarioRespuestaPreguntas;

    /** 
     * @ORM\OneToMany(
     *     targetEntity="FormatEasy\FormatosBundle\Entity\PreguntaFormato", 
     *     mappedBy="pregunta", 
     *     cascade={"persist","remove"}
     * )
     */
    private $formatos;

    /** 
     * @ORM\OneToMany(
     *     targetEntity="FormatEasy\FormatosBundle\Entity\Respuesta", 
     *     mappedBy="pregunta", 
     *     cascade={"persist","remove"}
     * )
     */
    private $respuestas;

    /** 
     * @ORM\ManyToOne(
     *     targetEntity="FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta", 
     *     inversedBy="preguntas", 
     *     cascade={"persist","remove"}
     * )
     * @ORM\JoinColumn(name="plantillaRespuestas", referencedColumnName="id", nullable=false)
     */
    private $plantilla;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->preguntasUsuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->respuestas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add preguntasUsuario
     *
     * @param \FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $preguntasUsuario
     * @return Pregunta
     */
    public function addPreguntasUsuario(\FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $preguntasUsuario)
    {
        $this->preguntasUsuario[] = $preguntasUsuario;
    
        return $this;
    }

    /**
     * Remove preguntasUsuario
     *
     * @param \FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $preguntasUsuario
     */
    public function removePreguntasUsuario(\FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $preguntasUsuario)
    {
        $this->preguntasUsuario->removeElement($preguntasUsuario);
    }

    /**
     * Get preguntasUsuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntasUsuario()
    {
        return $this->preguntasUsuario;
    }

    /**
     * Add formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\PreguntaFormato $formatos
     * @return Pregunta
     */
    public function addFormato(\FormatEasy\FormatosBundle\Entity\PreguntaFormato $formatos)
    {
        $this->formatos[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\PreguntaFormato $formatos
     */
    public function removeFormato(\FormatEasy\FormatosBundle\Entity\PreguntaFormato $formatos)
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

    /**
     * Add respuestas
     *
     * @param \FormatEasy\FormatosBundle\Entity\Respuesta $respuestas
     * @return Pregunta
     */
    public function addRespuesta(\FormatEasy\FormatosBundle\Entity\Respuesta $respuestas)
    {
        $this->respuestas[] = $respuestas;
    
        return $this;
    }

    /**
     * Remove respuestas
     *
     * @param \FormatEasy\FormatosBundle\Entity\Respuesta $respuestas
     */
    public function removeRespuesta(\FormatEasy\FormatosBundle\Entity\Respuesta $respuestas)
    {
        $this->respuestas->removeElement($respuestas);
    }

    /**
     * Get respuestas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }

    /**
     * Set plantilla
     *
     * @param \FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta $plantilla
     * @return Pregunta
     */
    public function setPlantilla(\FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta $plantilla)
    {
        $this->plantilla = $plantilla;
    
        return $this;
    }

    /**
     * Get plantilla
     *
     * @return \FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta 
     */
    public function getPlantilla()
    {
        return $this->plantilla;
    }
}