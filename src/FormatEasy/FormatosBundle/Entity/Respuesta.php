<?php
namespace FormatEasy\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Table(name="respuesta")
 * @ORM\Entity(repositoryClass="FormatEasy\FormatosBundle\Repository\RespuestaRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_respuesta", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_respuesta", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class Respuesta extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(
     *     targetEntity="FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato", 
     *     mappedBy="respuesta", 
     *     cascade={"persist","remove"}
     * )
     */
    private $usuariosRespuesta;

    /** 
     * @ORM\ManyToOne(
     *     targetEntity="FormatEasy\FormatosBundle\Entity\Pregunta", 
     *     inversedBy="respuestas", 
     *     cascade={"persist","remove"}
     * )
     * @ORM\JoinColumn(name="pregunta", referencedColumnName="id", nullable=false)
     */
    private $pregunta;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->usuariosRespuesta = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add usuariosRespuesta
     *
     * @param \FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $usuariosRespuesta
     * @return Respuesta
     */
    public function addUsuariosRespuesta(\FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $usuariosRespuesta)
    {
        $this->usuariosRespuesta[] = $usuariosRespuesta;
    
        return $this;
    }

    /**
     * Remove usuariosRespuesta
     *
     * @param \FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $usuariosRespuesta
     */
    public function removeUsuariosRespuesta(\FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $usuariosRespuesta)
    {
        $this->usuariosRespuesta->removeElement($usuariosRespuesta);
    }

    /**
     * Get usuariosRespuesta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuariosRespuesta()
    {
        return $this->usuariosRespuesta;
    }

    /**
     * Set pregunta
     *
     * @param \FormatEasy\FormatosBundle\Entity\Pregunta $pregunta
     * @return Respuesta
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
    
    public function __toString() {
        return $this->getNombre();
    }
    
    public function json($json = true){
        $datos = array(
            'id'                => $this->getId(),
            'nombre'            => $this->getNombre(),
            'descripcion'       => $this->getDescripcion(),
            'pregunta'         => $this->getPregunta(),
        );
        if($json)
            return json_encode($datos);
        return $datos;
    }
}