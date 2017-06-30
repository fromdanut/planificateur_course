<?php

namespace PC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
        ->add('styles', EntityType::class, array(
                   'class'        => 'PCPlatformBundle:Category',
                   'choice_label' => 'name',
                   'multiple'     => true,
                   'required'     => false,
                 ))
        ->add('nbMeal', IntegerType::class)
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
