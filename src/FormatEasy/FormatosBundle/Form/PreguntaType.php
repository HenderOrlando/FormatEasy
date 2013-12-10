<?php

namespace FormatEasy\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FormatEasy\PlantillasBundle\Form\DataTransformer\PlantillaRespuestaToIdTransformer;

class PreguntaType extends AbstractType
{
    private $opciones = array();
    public function __construct(array $options = array())
    {
        $this->opciones = $options;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('etiquetas')
        ;
        $plantilla = null;
        if(isset($options['plantilla'])){
            $plantilla = $options['plantilla'];
        }elseif(isset($this->opciones['plantilla'])){
            $plantilla = $this->opciones['plantilla'];
        }
        if(isset($options['em'])){
            $entityManager = $options['em'];
        }elseif(isset($this->opciones['em'])){
            $entityManager = $this->opciones['em'];
        }
        if(is_null($plantilla)){
            $builder->add('plantilla');
        }else{
            $transformer_plantillaRespuesta = new PlantillaRespuestaToIdTransformer($entityManager);
            $builder
                ->add($builder->create('plantilla', 'hidden', array(
                    'data' => $plantilla,
                    'data_class' => null
                ))
                ->addModelTransformer($transformer_plantillaRespuesta));
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormatEasy\FormatosBundle\Entity\Pregunta',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'formateasy_formatosbundle_pregunta';
    }
}
