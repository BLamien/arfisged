<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DefinitiveType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer le nom de la côte définitive.",
                  ),
                  'required'  => true,
            ))
            ->add('designation', TextareaType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'spellcheck'  => "false",
                       "rows" => "1",
                       'data-msg-required' =>  "Veuillez entrer la désignation de la côte définitive.",
                  ),
                  'required'  => true
            ))
            ->add('rayon', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer le rayon sur lequel est rangé la Côte définitive.",
                  ),
                  'required'  => false,
            ))
            ->add('position', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer la position occupée par la côte définitive.",
                  ),
                  'required'  => false,
            ))
            ->add('extreme', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer la date extrème de la côte définitive.",
                  ),
                  'required'  => true,
            ))
            ->add('vie', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer la durée de vie reservée à la côte définitive.",
                  ),
                  'required'  => false,
            ))
            //->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('provisoire', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Provisoire'
            ))
            ->add('epi', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Epi'
            ))
            ->add('sortfinal', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Sortfinal'
            ))
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Definitive'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_definitive';
    }


}
