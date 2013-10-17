<?php

namespace FormatEasy\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormatoType extends AbstractType
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
            ->add('etiquetas')
            ->add('plantillaPreguntas')
            ->add('PlantillaFormato')
            ->add('unidadMargen')
            ->add('margen_sup')
            ->add('margen_inf')
            ->add('margen_izq')
            ->add('margen_der')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormatEasy\FormatosBundle\Entity\Formato'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'formateasy_formatosbundle_formato';
    }
}
