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
            ->add('save','submit',[
                'label' => 'Sauvegarder'
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
        return 'gyg_appbundle_dechet_soin';
    }
}