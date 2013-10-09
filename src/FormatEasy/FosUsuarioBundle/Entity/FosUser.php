<?php
namespace FormatEasy\FosUsuarioBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class FosUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="FormatEasy\UsuariosBundle\Entity\Usuario")
     */
    protected $usuario;

    public function __construct()
    {
        parent::__construct();
    }
}