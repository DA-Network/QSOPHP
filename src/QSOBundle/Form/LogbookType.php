<?php

namespace QSOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogbookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('frequency', NumberType::class)
            ->add('rstSent')
            ->add('rstReceived')
            ->add('power', NumberType::class)
            ->add('comment', TextareaType::class, array(
                'required' => false,
                'attr' => array(
                    'class' => 'materialize-textarea'
                )
            ))
            ->add('logStart', DateTimeType::class, array(
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'datepicker_any'
                )
            ))
            ->add('logEnd', DateTimeType::class, array(
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'datepicker_any'
                )
            ))
            ->add('callsignAutocomplete', TextType::class, array(
                'mapped' => false,
                'attr' => array(
                    'data-activates' => 'autocomplete_results',
                    'data-beloworigin' => 'true',
                    'class' => 'autocomplete'
                )
            ))
            ->add('frequencyUnit')
            ->add('radioMode', null, array(
                'attr' => array(
                    'class' => 'auto-buttons'
                )
            ))
            ->add('band');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QSOBundle\Entity\Logbook'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'qsobundle_logbook';
    }

}
