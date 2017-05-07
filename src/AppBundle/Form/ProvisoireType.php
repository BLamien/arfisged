<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProvisoireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer le nom de la côte provisoire.",
                  ),
                  'required'  => true,
            ))
            ->add('designation', TextareaType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'spellcheck'  => "false",
                       "rows" => "3"
                  ),
                  'required'  => true
            ))
            //->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('conservation', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Conservation'
            ))
            ->add('sousserie', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Sousserie'
            ))
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Provisoire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_provisoire';
    }


}
