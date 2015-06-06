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
                'label' => 'Type de point d\'apport',
                'mapped' => false
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
            ->add('dechets','choice',[
                    'choices' => [
                        'menager' => 'Déchets ménagers',
                        'metallique' => 'Déchets métalliques',
                        'papier-carton' => 'Papiers/Cartons',
                        'plastique' => 'Plastiques',
                        'verre' => 'Verre',
                     ],
                    'label' => 'Type de dechets',
                    'multiple' => true,
                    'expanded' => true
            ])
            ->add('geojson', 'hidden', [
                'mapped' => false
            ])
            ->add('save','submit',[
                'label' => 'Sauvegarder',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
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
