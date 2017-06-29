<?php

namespace PC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PC\PlatformBundle\Form\RecipeOptionType;


class ShoppingListOptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('lunch', CheckboxType::class, array(
            'required' => false,
            'label'    => 'Lunch ?',
        ))
        ->add('dinner', CheckboxType::class, array(
            'required' => false,
            'label'    => 'Dinner ?',
        ))
        ->add('we', CheckboxType::class, array(
            'required' => false,
            'label'    => 'Week-end ?',
        ))
        ->add('styles', EntityType::class, array(
                   'class'        => 'PCPlatformBundle:Category',
                   'choice_label' => 'name',
                   'multiple'     => true,
                   'required'     => false,
                 ))

        ->add('save', SubmitType::class);
    }

    public function getParent()
    {
      return RecipeOptionType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pc_platformbundle_shoppinglistoption';
    }


}
