<?php
namespace FormatEasy\UsuariosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="FormatEasy\UsuariosBundle\Repository\UsuarioRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_usuario", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_usuario", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class Usuario extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(
     *     targetEntity="FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato", 
     *     mappedBy="usuario"
     * )
     */
    private $respuestasPreguntasFormatos;

    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\CommonBundle\Entity\Rol", inversedBy="usuarios")
     * @ORM\JoinTable(
     *     name="rol_usuario", 
     *     joinColumns={@ORM\JoinColumn(name="id_usuario", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_rol", referencedColumnName="id", nullable=false)}
     * )
     */
    private $roles;

    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\FormatosBundle\Entity\Formato", inversedBy="usuarios")
     * @ORM\JoinTable(
     *     name="formato_usuario", 
     *     joinColumns={@ORM\JoinColumn(name="id_usuario", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_formato", referencedColumnName="id", nullable=false)}
     * )
     */
    private $formatos;
    
    /** 
     * @ORM\Column(type="integer", nullable=false, name="doc_id")
     */
    private $docId;
    
    /** 
     * @ORM\Column(type="integer", nullable=false, name="tipo_doc_id")
     */
    private $tipoDocId;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->respuestasPreguntasFormatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Roles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add respuestasPreguntasFormatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $respuestasPreguntasFormatos
     * @return Usuario
     */
    public function addRespuestasPreguntasFormato(\FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $respuestasPreguntasFormatos)
    {
        $this->respuestasPreguntasFormatos[] = $respuestasPreguntasFormatos;
    
        return $this;
    }

    /**
     * Remove respuestasPreguntasFormatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $respuestasPreguntasFormatos
     */
    public function removeRespuestasPreguntasFormato(\FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato $respuestasPreguntasFormatos)
    {
        $this->respuestasPreguntasFormatos->removeElement($respuestasPreguntasFormatos);
    }

    /**
     * Get respuestasPreguntasFormatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestasPreguntasFormatos()
    {
        return $this->respuestasPreguntasFormatos;
    }

    /**
     * Add Roles
     *
     * @param \FormatEasy\CommonBundle\Entity\Rol $Roles
     * @return Usuario
     */
    public function addRole(\FormatEasy\CommonBundle\Entity\Rol $Roles)
    {
        $this->roles[] = $Roles;
    
        return $this;
    }

    /**
     * Remove Roles
     *
     * @param \FormatEasy\CommonBundle\Entity\Rol $Roles
     */
    public function removeRole(\FormatEasy\CommonBundle\Entity\Rol $Roles)
    {
        $this->roles->removeElement($Roles);
    }

    /**
     * Get Roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add Formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $Formatos
     * @return Usuario
     */
    public function addFormato(\FormatEasy\FormatosBundle\Entity\Formato $Formatos)
    {
        $this->formatos[] = $Formatos;
    
        return $this;
    }

    /**
     * Remove Formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $Formatos
     */
    public function removeFormato(\FormatEasy\FormatosBundle\Entity\Formato $Formatos)
    {
        $this->formatos->removeElement($Formatos);
    }

    /**
     * Get Formatos
     *
     * @return \Doctrine\Formatos\Collections\Collection 
     */
    public function getFormatos()
    {
        return $this->formatos;
    }
    
    /**
     * Get DocId
     *
     * @return Integer
     */
    public function getDocId()
    {
        return $this->docId;
    }
    
    /**
     * Set DocId
     *
     * @return Integer
     */
    public function setDocId()
    {
        return $this->docId;
    }
    /**
     * Get DocId
     *
     * @return Integer
     */
    public function getTipoDocId()
    {
        return $this->tipoDocId;
    }
    
    /**
     * Set DocId
     *
     * @return Integer
     */
    public function setTipoDocId()
    {
        return $this->tipoDocId;
    }
}