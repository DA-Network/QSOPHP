<?php

namespace QSOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array(
                'label' => 'Firstname'
            ))
            ->add('lastname', null, array(
                'label' => 'Lastname'
            ))
            ->add('email', null, array(
                'label' => 'E-mail Address'
            ))
            ->add('callsignName', TextType::class, array(
                'label' => 'Call Sign'
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Password'
            ))
            ->add('plainPasswordCompare', PasswordType::class, array(
                'label' => 'Password Confirmation'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QSOBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'qsobundle_user';
    }
}