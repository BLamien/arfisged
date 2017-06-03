<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', TextType::class, array(
              'attr'  => array(
                  'class' => 'md-form-control',
                  'autocomplete'  => 'off',
                  'spellcheck'  => "false",
                  'data-msg-required' =>  "Veuillez entrer le nom utilisateur.",
              ),
              'required'  => true,
        ))
        //->add('usernameCanonical')
        ->add('email', EmailType::class, array(
            'attr'  => array(
                'class' => 'md-form-control',
                'autocomplete'  => 'off',
                'spellcheck'  => "false",
                'data-msg-required' =>  "Veuillez entrer l'adresse email.",
            ),
            'required'  => true,
        ))
        //->add('emailCanonical')
        ->add('enabled', null, array(
              'attr'  => array(
                  'class' => 'custom-control-input',
              ),
              'required'  => false,
        ))
        //->add('salt')
        ->add('password', PasswordType::class, array(
            'attr'  => array(
                'class' => 'md-form-control',
                'autocomplete'  => 'off',
                'spellcheck'  => "false",
                'data-rule-minlength' =>  "6",
                'data-msg-required' =>  "Veuillez entrer le mot de passe.",
                'data-msg-minlength'  =>  "Veuillez entrer au moins 6 caractères.",
            ),
            'required'  => true,
        ))
        //->add('lastLogin')
        //->add('locked')
        //->add('expired')
        //->add('expiresAt')
        //->add('confirmationToken')
        //->add('passwordRequestedAt')
        ->add('roles', ChoiceType::class, array(
              'choices' => array(
                'UTILISATEUR . . .'  => 'ROLE_USER',
                'ADMINISTRATEUR '  => 'ROLE_ADMIN',
                //'SUPER ADMINISTRATEUR '  => 'ROLE_SUPER_ADMIN',
              ),
              'multiple'  => true,
              'expanded'  => true
        ))
        //->add('credentialsExpired')
        //->add('credentialsExpireAt')
        //->add('loginCount')
        //->add('firstLogin')
        //->add('groups')

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
