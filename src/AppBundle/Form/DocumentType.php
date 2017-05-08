<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DocumentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer la reference du document.",
                  ),
                  'required'  => true,
            ))
            ->add('libelle', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer le nom du document.",
                  ),
                  'required'  => true,
            ))
            ->add('resume', TextareaType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'spellcheck'  => "false",
                       "rows" => "3",
                       'data-msg-required' =>  "Veuillez saisir le resumé.",
                  ),
                  'required'  => true
            ))
            ->add('tags', TextareaType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'spellcheck'  => "false",
                       "rows" => "3"
                  ),
                  'required'  => false
            ))
            ->add('dateprod', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer la date de production.",
                      'data-provide'  =>  "datepicker",
                      'data-date-today-highlight' =>  "true",
                  ),
                  'required'  => true,
            ))
            ->add('datefin', TextType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                      'autocomplete'  => 'off',
                      'spellcheck'  => "false",
                      'data-msg-required' =>  "Veuillez entrer la date de fin.",
                      'data-provide'  =>  "datepicker",
                      'data-date-today-highlight' =>  "true",
                  ),
                  'required'  => true,
            ))
            ->add('transfert', null, array(
                  'attr'  => array(
                      'class' => 'custom-control-input',
                  )
            ))
            ->add('partage', null, array(
                  'attr'  => array(
                      'class' => 'custom-control-input',
                  )
            ))
            ->add('stagiaire', null, array(
                  'attr'  => array(
                      'class' => 'custom-control-input',
                  )
            ))
            ->add('assistant', null, array(
                  'attr'  => array(
                      'class' => 'custom-control-input',
                  )
            ))
            ->add('adjoint', null, array(
                  'attr'  => array(
                      'class' => 'custom-control-input',
                  )
            ))
            ->add('chef', null, array(
                  'attr'  => array(
                      'class' => 'custom-control-input',
                  )
            ))
            //->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('service', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Service'
            ))
            ->add('rubrique', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Rubrique'
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
            'data_class' => 'AppBundle\Entity\Document'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_document';
    }


}
