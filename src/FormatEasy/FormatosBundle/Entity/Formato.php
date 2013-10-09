<?php
namespace FormatEasy\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="formato")
 * @ORM\Entity(repositoryClass="FormatEasy\FormatosBundle\Repository\FormatoRepository")
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
     * @ORM\ManyToOne(targetEntity="FormatEasy\PlantillasBundle\Entity\Plantilla", inversedBy="Formatos")
     * @ORM\JoinColumn(name="plantillaFormato", referencedColumnName="id", nullable=false)
     */
    private $PlantillaFormato;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->usuariosFormato = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \FormatEasy\PlantillasBundle\Entity\Plantilla $plantillaFormato
     * @return Formato
     */
    public function setPlantillaFormato(\FormatEasy\PlantillasBundle\Entity\Plantilla $plantillaFormato)
    {
        $this->PlantillaFormato = $plantillaFormato;
    
        return $this;
    }

    /**
     * Get PlantillaFormato
     *
     * @return \FormatEasy\PlantillasBundle\Entity\Plantilla 
     */
    public function getPlantillaFormato()
    {
        return $this->PlantillaFormato;
    }
}