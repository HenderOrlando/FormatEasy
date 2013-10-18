<?php
namespace FormatEasy\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="usuario_respuesta_pregunta_formato")
 * @ORM\Entity(repositoryClass="FormatEasy\FormatosBundle\Repository\UsuarioRespuestaPreguntaFormatoRepository")
 */
class UsuarioRespuestaPreguntaFormato
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;

    /** 
     * @ORM\Column(type="text", nullable=true, name="valor")
     */
    private $valor;
    
    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\UsuariosBundle\Entity\Usuario", inversedBy="respuestasPreguntasFormatos")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\FormatosBundle\Entity\Respuesta", inversedBy="usuariosRespuesta")
     * @ORM\JoinColumn(name="respuesta", referencedColumnName="id", nullable=false)
     */
    private $respuesta;

    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\FormatosBundle\Entity\Pregunta", inversedBy="preguntasUsuario")
     * @ORM\JoinColumn(name="pregunta", referencedColumnName="id", nullable=false)
     */
    private $pregunta;

    /** 
     * @ORM\ManyToOne(targetEntity="FormatEasy\FormatosBundle\Entity\Formato", inversedBy="usuariosFormato")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;
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
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return UsuarioRespuestaPreguntaFormato
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
     * Set usuario
     *
     * @param \FormatEasy\UsuariosBundle\Entity\Usuario $usuario
     * @return UsuarioRespuestaPreguntaFormato
     */
    public function setUsuario(\FormatEasy\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return \FormatEasy\UsuariosBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set respuesta
     *
     * @param \FormatEasy\FormatosBundle\Entity\Respuesta $respuesta
     * @return UsuarioRespuestaPreguntaFormato
     */
    public function setRespuesta(\FormatEasy\FormatosBundle\Entity\Respuesta $respuesta)
    {
        $this->respuesta = $respuesta;
    
        return $this;
    }

    /**
     * Get respuesta
     *
     * @return \FormatEasy\FormatosBundle\Entity\Respuesta 
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set pregunta
     *
     * @param \FormatEasy\FormatosBundle\Entity\Pregunta $pregunta
     * @return UsuarioRespuestaPreguntaFormato
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
     * Set formato
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $formato
     * @return UsuarioRespuestaPreguntaFormato
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
     * Set valor
     *
     * @param string $valor
     * @return Objeto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }
}