<?php

namespace FormatEasy\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioRespuestaPreguntaFormatoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaCreado')
            ->add('usuario')
            ->add('respuesta')
            ->add('pregunta')
            ->add('formato')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormatEasy\FormatosBundle\Entity\UsuarioRespuestaPreguntaFormato'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'formateasy_formatosbundle_usuariorespuestapreguntaformato';
    }
}
