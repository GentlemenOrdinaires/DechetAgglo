<?php

namespace GYG\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PointApportType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('infos','textarea',[
                'label' => 'Informations',
                'attr' => [
                    'class' => 'ckeditor'
                ]
            ])
            ->add('photo','file',[
                'label' => 'Photo',
                'required' => false
            ])
            ->add('logo','file',[
                'label' => 'Logo'
            ])
            ->add('dechets','collection',[
                'type' => 'choice',
                'options' => [
                    'choices' => [
                        'menager' => 'Déchets ménagers',
                        'metallique' => 'Déchets métalliques',
                        'papierCarton' => 'Papiers/Cartons',
                        'plastique' => 'Plastiques',
                        'vere' => 'Verre',
                    ],
                    'empty_value' => 'Choisissez un type de déchets',
                    'empty_data' => null
                ],
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('save','submit',[
                'label' => 'Sauvegarder'
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'GYG\AppBundle\Entity\PointApport'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gyg_appbundle_pointapport';
    }
}
