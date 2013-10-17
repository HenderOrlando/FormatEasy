<?php
namespace FormatEasy\PlantillasBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Table(name="plantilla_pregunta")
 * @ORM\Entity(repositoryClass="FormatEasy\PlantillasBundle\Repository\PlantillaPreguntaRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="etiquetas",
 *          joinTable=@ORM\JoinTable(
 *              name="etiqueta_plantilla_pregunta", 
 *              joinColumns={@ORM\JoinColumn(name="id_objeto_plantilla_pregunta", referencedColumnName="id", nullable=false)}, 
 *              inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
 *          )
 *      )
 * })
 */
class PlantillaPregunta extends \FormatEasy\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="text", nullable=false, name="codigo")
     */
    private $codigo;
    
    /** 
     * @ORM\OneToMany(targetEntity="FormatEasy\FormatosBundle\Entity\Formato", mappedBy="plantillaPreguntas")
     */
    private $formatos;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return PlantillaPregunta
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
     * Add formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $formatos
     * @return PlantillaPregunta
     */
    public function addFormato(\FormatEasy\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatos[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \FormatEasy\FormatosBundle\Entity\Formato $formatos
     */
    public function removeFormato(\FormatEasy\FormatosBundle\Entity\Formato $formatos)
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
    
    public function __toString() {
        return $this->getNombre();
    }
    
    public function json($json = true){
        $datos = array(
            'id'            => $this->getId(),
            'nombre'        => $this->getNombre(),
            'descripcion'   => $this->getDescripcion(),
            'codigo'        => $this->getCodigo(),
            'fechaCreado'   => $this->getFechaCreado(),
        );
        if($json)
            return json_encode($datos);
        return $datos;
    }
}