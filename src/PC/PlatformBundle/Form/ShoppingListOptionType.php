<?php

namespace PC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ShoppingListOptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('eco', ChoiceType::class, array(
            'choices'  => array(
                'Yep'   => true,
                'Nop'    => false,
        )))
        ->add('quick', ChoiceType::class, array(
            'choices'  => array(
                'Yep'   => true,
                'Nop'    => false,
        )))
        ->add('diet', ChoiceType::class, array(
            'choices'  => array(
                'Yep'   => true,
                'Nop'    => false,
        )))
        ->add('lunch', ChoiceType::class, array(
            'choices'  => array(
                'Yep'   => true,
                'Nop'    => false,
        )))
        ->add('dinner', ChoiceType::class, array(
            'choices'  => array(
                'Yep'   => true,
                'Nop'    => false,
        )))
        ->add('we', ChoiceType::class, array(
            'choices'  => array(
                'Yep'   => true,
                'Nop'    => false,
        )))
        ->add('bestRating', ChoiceType::class, array(
            'choices'  => array(
                'Yep'   => true,
                'Nop'    => false,
        )))
        ->add('styles', EntityType::class, array(
                  'class'        => 'PCPlatformBundle:Category',
                  'choice_label' => 'name',
                  'multiple'     => true,
                ))
        ->add('save', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PC\PlatformBundle\Entity\ShoppingListOption'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pc_platformbundle_shoppinglistoption';
    }


}
