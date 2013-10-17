<?php

namespace FormatEasy\PlantillasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HojaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('orientacion', 'choice', array(
                'choices'   => array(
                    1   => 'Horizontal',
                    0   => 'Vertical',
                ),
                'multiple'  => false,
            ))
            ->add('unidad')
            ->add('ancho')
            ->add('alto')
            ->add('etiquetas')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormatEasy\PlantillasBundle\Entity\Hoja'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'formateasy_plantillasbundle_hoja';
    }
}
