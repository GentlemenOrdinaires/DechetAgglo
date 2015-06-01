<?php

namespace GYG\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PointApportType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('type','choice',[
                'choices' => [
                    'aerien' => 'Point d\'apport aerien',
                    'enterre' => 'Point d\'apport enterre'
                ],
                'empty_value' => 'Choisissez un type de point d\'apport',
                'empty_data' => null,
                'label' => 'Type de point d\'apport'
            ])
            ->add('infos','textarea',[
                'label' => 'Informations',
                'attr' => [
                    'class' => 'ckeditor'
                ]
            ])
            ->add('filePhoto','file',[
                'label' => 'Photo',
                'required' => false
            ])
            ->add('dechets','collection',[
                'type' => 'choice',
                'options' => [
                    'choices' => [
                        'menager' => 'Déchets ménagers',
                        'metallique' => 'Déchets métalliques',
                        'papierCarton' => 'Papiers/Cartons',
                        'plastique' => 'Plastiques',
                        'verre' => 'Verre',
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
    }



    /**
     * @return string
     */
    public function getName()
    {
        return 'gyg_appbundle_pointapport';
    }
}
