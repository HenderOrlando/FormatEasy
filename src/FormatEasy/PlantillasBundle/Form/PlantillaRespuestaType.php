<?php

namespace FormatEasy\PlantillasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlantillaRespuestaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = array(
            'Texto' => array(
                'text'      => 'Texto Corto',
                'textarea'  => 'Texto Largo',
                'email'     => 'Email',
                'integer'   => 'Número Entero',
                'money'     => 'Dinero',
                'number'    => 'Numero',
                'password'  => 'Clave',
                'percent'   => 'Porcentaje',
                'search'    => 'Búsqueda',
                'url'       => 'Url',
            ),
            'Selección' => array(
                'choice'    =>  'Seleccionar uno',
                'choice-multiple'    =>  'Seleccionar varios',
                'radio'     =>  'Selector Radio',
                'checkbox'  =>  'Selector Checkbox',
            ),
            'Fechas y Horas' => array(
                'date'      =>  'Fecha',
                'time'      =>  'Hora',
                'datetime'  =>  'Fecha y hora',
            ),
            'Otros' => array(
                
            ),
        );
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('codigo')
            ->add('widget', 'choice', array(
                    'choices'   => $choices,
                )
            )
            ->add('etiquetas')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormatEasy\PlantillasBundle\Entity\PlantillaRespuesta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'formateasy_plantillasbundle_plantillarespuesta';
    }
}
