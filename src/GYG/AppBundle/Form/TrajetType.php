<?php
/**
 * Created by PhpStorm.
 * User: yassir
 * Date: 03/06/2015
 * Time: 11:04
 */

namespace GYG\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrajetType extends AbstractType{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('couleur','text',[
                'label' => 'Couleur',
                'attr' => [
                    'id' => 'couleur'
                ]
            ])
            ->add('jourCollecte','textarea',[
                'label' => 'Jour de collecte',
                'attr' => [
                    'class' => 'ckeditor'
                ]
            ])
            ->add('jourCollecteSelective','textarea',[
                'label' => 'Jour de collecte selective',
                'attr' => [
                    'class' => 'ckeditor'
                ]
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
            'data_class' => 'GYG\AppBundle\Entity\Trajet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gyg_appbundle_trajet';
    }
}