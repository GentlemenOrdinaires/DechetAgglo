<?php

namespace GYG\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DechetType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('couleur','text',array(
                'label' => 'Couleurs'
            ))
            ->add('libelle','text',array(
                'label' => 'Libellé'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GYG\AppBundle\Entity\Dechet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gyg_appbundle_dechet';
    }
}
