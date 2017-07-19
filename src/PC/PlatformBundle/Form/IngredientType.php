<?php

namespace PC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class IngredientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',    TextType::class)
            ->add('price',   IntegerType::class )
            ->add('calorie', IntegerType::class )
            ->add('unit',    EntityType::class, array(
                'class'        => 'PCPlatformBundle:Unit',
                'choice_label' => 'name',
                'multiple'     => false,
                'expanded'     => false,
            ))
            ->add('category',    EntityType::class, array(
                'class'        => 'PCPlatformBundle:CategoryIngredient',
                'choice_label' => 'name',
                'multiple'     => false,
                'expanded'     => false,
            ))
            ->add('save',    SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PC\PlatformBundle\Entity\Ingredient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pc_platformbundle_ingredient';
    }


}
