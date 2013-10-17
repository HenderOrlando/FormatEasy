<?php
namespace FormatEasy\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;
/*
 * @ORM\Entity
 * @ORM\Table(name="objeto")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="aplicable_a", length=50, type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "Etiqueta"="FormatEasy\CommonBundle\Entity\Etiqueta",
 *     "Rol"="FormatEasy\CommonBundle\Entity\Rol",
 *     "Usuario"="FormatEasy\UsuariosBundle\Entity\Usuario",
 *     "Formato"="FormatEasy\FormatosBundle\Entity\Formato",
 *     "Pregunta"="FormatEasy\FormatosBundle\Entity\Pregunta",
 *     "PreguntaFormato"="FormatEasy\FormatosBundle\Entity\PreguntaFormato",
 *     "Respuesta"="FormatEasy\FormatosBundle\Entity\Respuesta",
 *     "Hoja"="FormatEasy\PlantillasBundle\Entity\Hoja"
 *     "PlantillaFormato"="FormatEasy\PlantillasBundle\Entity\PlantillaFormato"
 *     "PlantillaPregunta"="FormatEasy\PlantillasBundle\Entity\PlantillaPregunta"
 *     "PlantillaRespuesta"="FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta"
 * })
 */

/** 
 * @ORM\MappedSuperclass
 */
class Objeto
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=100, nullable=true, name="nombre")
     */
    private $nombre;

    /** 
     * @ORM\Column(type="string", length=100, nullable=true, name="canonical")
     */
    private $canonical;

    /** 
     * @ORM\Column(type="text", nullable=true, name="descripcion")
     */
    private $descripcion;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;

    /** 
     * @ORM\ManyToMany(targetEntity="FormatEasy\CommonBundle\Entity\Etiqueta", inversedBy="objetos")
     * @ORM\JoinTable(
     *     name="etiqueta_objeto", 
     *     joinColumns={@ORM\JoinColumn(name="id_objeto", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_etiqueta", referencedColumnName="id", nullable=false)}
     * )
     */
    private $etiquetas;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Objeto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->canonical = $this->replaceAccents($nombre);
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set canonical
     *
     * @param string $canonical
     * @return Objeto
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $this->replaceAccents($canonical);
    
        return $this;
    }
    
    /**
     * Get canonical
     *
     * @return string 
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Objeto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return Objeto
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
     * Add etiquetas
     *
     * @param \FormatEasy\CommonBundle\Entity\Etiqueta $etiquetas
     * @return Objeto
     */
    public function addEtiqueta(\FormatEasy\CommonBundle\Entity\Etiqueta $etiquetas)
    {
        $this->etiquetas[] = $etiquetas;
    
        return $this;
    }

    /**
     * Remove etiquetas
     *
     * @param \FormatEasy\CommonBundle\Entity\Etiqueta $etiquetas
     */
    public function removeEtiqueta(\FormatEasy\CommonBundle\Entity\Etiqueta $etiquetas)
    {
        $this->etiquetas->removeElement($etiquetas);
    }

    /**
     * Get etiquetas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEtiquetas()
    {
        return $this->etiquetas;
    }
    
    public function __toString() {
        return $this->getNombre();
    }
    
    /**
     * replaceAccents()
     * 
     *  Esta función remplaza todos los caracteres especiales de un texto dado por su equivalente
     * @param       string $str
     * @return      Retorna el nuevo String sin caracteres especiales
     */
    protected function replaceAccents($str){
        $str = str_replace(array('ẅ','ẃ','ẁ','ŵ'),"w",$str);
        $str = str_replace(array('Ẅ','Ẃ','Ẁ','Ŵ'),"W",$str);
        $str = str_replace(array('ś','ŝ'),"s",$str);
        $str = str_replace(array('Ś','Ŝ'),"S",$str);
        $str = str_replace(array('ǵ','ĝ'),"g",$str);
        $str = str_replace(array('Ǵ','Ĝ'),"G",$str);
        $str = str_replace(array('ź','ẑ'),"z",$str);
        $str = str_replace(array('Ź','Ẑ'),"Z",$str);
        $str = str_replace(array('ĥ','ḧ'),"h",$str);
        $str = str_replace(array('Ĥ','Ḧ'),"H",$str);
        $str = str_replace(array('ä','á','à','â','ã','ª'),"a",$str);
        $str = str_replace(array('Á','À','Â','Ã','Ä'),"A",$str);
        $str = str_replace(array('é','è','ê','ë'),"e",$str);
        $str = str_replace(array('É','È','Ê','Ë'),"E",$str);
        $str = str_replace(array('í','ì','î','ï'),"i",$str);
        $str = str_replace(array('Í','Ì','Î','Ï'),"I",$str);
        $str = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$str);
        $str = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$str);
        $str = str_replace(array('ú','ù','û','ü','ǘ'),"u",$str);
        $str = str_replace(array('Ú','Ù','Û','Ü','Ǘ'),"U",$str);
        $str = str_replace(array('|','@','·','~','½','¬','{','[',']','}','\\','¸','~','¨','þ','ø','→','↓','←','ŧ','¶','€','ł','@','æ','ß','ð','đ','ŋ','ħ','ł','^','̣̣̣̣̣|','«','»','¢','“','”','µ','─','·','̣·',"'",'+','´','{','}','.',',','´','`','!','"','#','$','%','&','/','(',')','=','?','¡','*','¨','[','_',':',';','¿'),"",$str);
        $str = str_replace(array('ç','ć','ĉ'),"c",$str);
        $str = str_replace(array('Ç','Ć','Ĉ'),"C",$str);
        $str = str_replace(array('ñ','ń','ǹ'),"n",$str);
        $str = str_replace(array('Ñ','Ń','Ǹ'),"N",$str);
        $str = str_replace(array('ý','ŷ','ỳ','ÿ'),"y",$str);
        $str = str_replace(array('Ý','Ŷ','Ỳ','Ÿ'),"Y",$str);
        $str = str_replace("ẍ","x",$str);
        $str = str_replace('Ẍ',"X",$str);
        $str = str_replace("ḿ","m",$str);
        $str = str_replace("Ḿ","M",$str);
        $str = str_replace("ẗ","t",$str);
        $str = str_replace("ŕ","r",$str);
        $str = str_replace("Ŕ","R",$str);
        $str = str_replace("ṕ","r",$str);
        $str = str_replace("Ṕ","P",$str);
        $str = str_replace("ĵ","j",$str);
        $str = str_replace("Ĵ","J",$str);
        $str = str_replace("ḱ","k",$str);
        $str = str_replace("Ḱ","K",$str);
        $str = str_replace("ĺ","l",$str);
        $str = str_replace("Ĺ","L",$str);
        $str = str_replace(" ","-",$str);
        return $str;
    }
}