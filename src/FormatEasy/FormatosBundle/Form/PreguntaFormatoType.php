<?php

namespace FormatEasy\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FormatEasy\FormatosBundle\Form\DataTransformer\FormatoToIdTransformer;
use FormatEasy\PlantillasBundle\Form\DataTransformer\PlantillaRespuestaToIdTransformer;

class PreguntaFormatoType extends AbstractType
{
    private $opciones = array();
    public function __construct(array $opciones = array())
    {
        $this->opciones = $opciones;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(isset($options['form_pregunta']) || isset($this->opciones['form_pregunta'])){
            if(isset($options['form_pregunta'])){
                $builder->add('pregunta', $options['form_pregunta']);
            }elseif(isset($this->opciones['form_pregunta'])){
                $builder->add('pregunta', $this->opciones['form_pregunta']);
            }
        }else{
            $builder
                ->add('nombre')
                ->add('descripcion')
                ->add('etiquetas')
                ->add('pregunta');
        }
        if(isset($options['em'])){
            $entityManager = $options['em'];
        }elseif(isset($this->opciones['em'])){
            $entityManager = $this->opciones['em'];
        }
        $transformer_formato = new FormatoToIdTransformer($entityManager);
        $builder->add($builder->create('formato', 'hidden')->addModelTransformer($transformer_formato));
        
        $transformer_plantillaRespuesta = new PlantillaRespuestaToIdTransformer($entityManager);
        $builder->add($builder->create('PlantillaRespuesta', 'hidden')->addModelTransformer($transformer_plantillaRespuesta));
        
        if((isset($options['orden']) && $options['orden']) || (isset($this->opciones['orden']) && $this->opciones['orden'])){
            $builder->add('orden', 'hidden');
        }else{
            $builder->add('orden');
        }
        $builder->add('grupo');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormatEasy\FormatosBundle\Entity\PreguntaFormato',
            'cascade_validation' => true,
        ));
        $resolver->setRequired(array(
            'em',
        ));
        $resolver->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'formateasy_formatosbundle_preguntaformato';
    }
}
