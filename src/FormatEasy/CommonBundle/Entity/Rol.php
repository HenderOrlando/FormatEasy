<?php
namespace FormatEasy\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="rol")
 * @ORM\Entity(repositoryClass="FormatEasy\CommonBundle\Repository\RolRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_rol", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_rol", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class Rol extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="string", length=105, nullable=false, name="role")
     */
    private $role;

    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\UsuariosBundle\Entity\Usuario", mappedBy="roles")
     */
    private $usuarios;
    
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
        $this->usuarios[] = $Usuarios;
    
        return $this;
    }

    /**
     * Remove Usuarios
     *
     * @param \FormatEasy\UsuariosBundle\Entity\Usuario $Usuarios
     */
    public function removeUsuario(\FormatEasy\UsuariosBundle\Entity\Usuario $Usuarios)
    {
        $this->usuarios->removeElement($Usuarios);
    }

    /**
     * Get Usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
}