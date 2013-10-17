<?php
namespace FormatEasy\PlantillasBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Table(name="plantilla_respuesta")
 * @ORM\Entity(repositoryClass="FormatEasy\PlantillasBundle\Repository\PlantillaRespuestaRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_plantilla_respuesta", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_plantilla_respuesta", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class PlantillaRespuesta extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="text", nullable=false, name="codigo")
     */
    private $codigo;
    
    /** 
     * @ORM\Column(type="string", length=50, nullable=false, name="widget")
     */
    private $widget;

    /** 
     * @ORM\OneToMany(targetEntity="FormatEasy\FormatosBundle\Entity\Pregunta", mappedBy="plantilla")
     */
    private $preguntas;

    /** 
     * @ORM\OneToMany(targetEntity="FormatEasy\FormatosBundle\Entity\PreguntaFormato", mappedBy="PlantillaRespuesta")
     */
    private $PreguntaFormatos;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->PreguntaFormatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return PlantillaRespuesta
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
     * Set widget
     *
     * @param string $widget
     * @return PlantillaRespuesta
     */
    public function setWidget($widget)
    {
        $this->widget = $widget;
    
        return $this;
    }

    /**
     * Get widget
     *
     * @return string 
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * Add preguntas
     *
     * @param \FormatEasy\FormatosBundle\Entity\Pregunta $preguntas
     * @return PlantillaRespuesta
     */
    public function addPregunta(\FormatEasy\FormatosBundle\Entity\Pregunta $preguntas)
    {
        $this->preguntas[] = $preguntas;
    
        return $this;
    }

    /**
     * Remove preguntas
     *
     * @param \FormatEasy\FormatosBundle\Entity\Pregunta $preguntas
     */
    public function removePregunta(\FormatEasy\FormatosBundle\Entity\Pregunta $preguntas)
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
     * Add PreguntaFormatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\PreguntaFormato $preguntaFormatos
     * @return PlantillaRespuesta
     */
    public function addPreguntaFormato(\FormatEasy\FormatosBundle\Entity\PreguntaFormato $preguntaFormatos)
    {
        $this->PreguntaFormatos[] = $preguntaFormatos;
    
        return $this;
    }

    /**
     * Remove PreguntaFormatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\PreguntaFormato $preguntaFormatos
     */
    public function removePreguntaFormato(\FormatEasy\FormatosBundle\Entity\PreguntaFormato $preguntaFormatos)
    {
        $this->PreguntaFormatos->removeElement($preguntaFormatos);
    }

    /**
     * Get PreguntaFormatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntaFormatos()
    {
        return $this->PreguntaFormatos;
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
            'widget'        => $this->getWidget(),
            'fechaCreado'   => $this->getFechaCreado(),
        );
        if($json)
            return json_encode($datos);
        return $datos;
    }
}