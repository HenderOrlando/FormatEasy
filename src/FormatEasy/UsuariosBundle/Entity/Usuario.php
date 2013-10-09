<?php
namespace FormatEasy\UsuariosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="FormatEasy\UsuariosBundle\Repository\UsuarioRepository")
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
     * @ORM\ManyToMany(targetEntity="FormatEasy\CommonBundle\Entity\Rol", inversedBy="Usuarios")
     * @ORM\JoinTable(
     *     name="RolUsuario", 
     *     joinColumns={@ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol", referencedColumnName="id", nullable=false)}
     * )
     */
    private $Roles;
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
        $this->Roles[] = $Roles;
    
        return $this;
    }

    /**
     * Remove Roles
     *
     * @param \FormatEasy\CommonBundle\Entity\Rol $Roles
     */
    public function removeRole(\FormatEasy\CommonBundle\Entity\Rol $Roles)
    {
        $this->Roles->removeElement($Roles);
    }

    /**
     * Get Roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->Roles;
    }
}