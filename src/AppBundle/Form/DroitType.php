<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DroitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lecture', null, array(
                  'attr'  => array(
                      'class' => 'custom-control-input',
                  ),
                  'required'  => false,
            ))
            ->add('ecriture', null, array(
                  'attr'  => array(
                      'class' => 'custom-control-input',
                  ),
                  'required'  => false,
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
            //->add('niveau')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('rubrique', EntityType::class, array(
                  'attr'  => array(
                      'class' => 'md-form-control',
                  ),
                'class' => 'AppBundle:Rubrique'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Droit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_droit';
    }


}
