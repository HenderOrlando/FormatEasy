<?php

namespace FormatEasy\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreguntaFormatoType extends AbstractType
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
            ->add('orden')
            ->add('etiquetas')
            ->add('formato')
            ->add('pregunta')
            ->add('PlantillaRespuesta')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormatEasy\FormatosBundle\Entity\PreguntaFormato'
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
