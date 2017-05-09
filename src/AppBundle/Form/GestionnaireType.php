<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GestionnaireType extends AbstractType
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
                      'data-msg-required' =>  "Veuillez entrer le nom de famille.",
                  ),
                  'required'  => true,
            ))
            ->add('prenom', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer le prenom.",
                  ),
                  'required'  => true,
            ))
            ->add('fonction', ChoiceType::class, array(
                  'choices' => array(
                    'STAGIAIRE'  => 'STAGIAIRE',
                    'ASSISTANT '  => 'ASSISTANT',
                    'ADJOINT'  => 'ADJOINT',
                    'CHEF'  => 'CHEF',
                    'DIRECTEUR'  => 'DIRECTEUR',
                  ),
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
            ))
            ->add('contact', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'data-rule-maxlength' =>  "8",
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer le contact téléphonique.",
                      'data-msg-maxlength'  =>  "Le numéro de telephone doit comporter 8 chiffres sans espace ni tirait",
                  ),
                  'required'  => true,
            ))
            //->add('niveau')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('user', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:User'
            ))
            ->add('service', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Service'
            ))
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Gestionnaire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_gestionnaire';
    }


}
