<?php
namespace FormatEasy\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="rol")
 * @ORM\Entity(repositoryClass="FormatEasy\CommonBundle\Repository\RolRepository")
 */
class Rol extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="string", length=105, nullable=false, name="role")
     */
    private $role;

    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\UsuariosBundle\Entity\Usuario", mappedBy="Roles")
     */
    private $Usuarios;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->Usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set role
     *
     * @param string $role
     * @return Rol
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add Usuarios
     *
     * @param \FormatEasy\UsuariosBundle\Entity\Usuario $Usuarios
     * @return Rol
     */
    public function addUsuario(\FormatEasy\UsuariosBundle\Entity\Usuario $Usuarios)
    {
        $this->Usuarios[] = $Usuarios;
    
        return $this;
    }

    /**
     * Remove Usuarios
     *
     * @param \FormatEasy\UsuariosBundle\Entity\Usuario $Usuarios
     */
    public function removeUsuario(\FormatEasy\UsuariosBundle\Entity\Usuario $Usuarios)
    {
        $this->Usuarios->removeElement($Usuarios);
    }

    /**
     * Get Usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->Usuarios;
    }
}