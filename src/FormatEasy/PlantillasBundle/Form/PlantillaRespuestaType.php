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
        $builder
            ->add('nombre')
            ->add('canonical')
            ->add('descripcion')
            ->add('fechaCreado')
            ->add('codigo')
            ->add('widget')
            ->add('etiquetas')
            ->add('Hoja')
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
