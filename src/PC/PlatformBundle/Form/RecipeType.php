<?php

namespace PC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class RecipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' ,              TextType::class)
            ->add('cookingTime',        IntegerType::class, array(
                'label'        => 'Temps de préparation (mn)',
                'attr'         => array('min' => 0)))
            ->add('longDescription',    TextareaType::class)
            ->add('shortDescription',   TextareaType::class, array('required' => false))
            ->add('recipeIngredients',  CollectionType::class, array(
                    'entry_type'   => RecipeIngredientType::class,
                    'allow_add'    => true,
                    'allow_delete' => true
                    ))
            ->add('categories',         EntityType::class, array(
                      'class'        => 'PCPlatformBundle:Category',
                      'choice_label' => 'name',
                      'multiple'     => true,
                    ))
            ->add('rating',            RangeType::class,  array(
                    'label' => 'Note',
                    'attr'  => array(
                        'min' => 0,
                        'max' => 5)))
            ->add('nbPerson',          IntegerType::class, array(
                'label'        => 'Nombre de personne',
                'attr'         => array('min' => 1)))
            ->add('image',             ImageType::class)
            ->add('save',              SubmitType::class, array('label' => 'Enregistrer la recette'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PC\PlatformBundle\Entity\Recipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pc_platformbundle_recipe';
    }
}
