<?php
/**
 * Created by PhpStorm.
 * User: yassir
 * Date: 03/06/2015
 * Time: 09:33
 */

namespace GYG\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GYG\AppBundle\Service\GeoJson;


class DechetSoinType extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('geojson', 'hidden', [
                'mapped' => false,
                'attr' => [
                    'class' => 'geojson-value'
                ]
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
        $resolver->setDefaults(array(
            'data_class' => 'GYG\AppBundle\Entity\DechetSoin'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gyg_appbundle_dechetsoin';
    }
}