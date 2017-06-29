<?php

namespace PC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RecipeOptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eco', CheckboxType::class, array(
                'required' => false,
                'label'    => 'Economique ?',
            ))
            ->add('quick', CheckboxType::class, array(
                'required' => false,
                'label'    => 'Rapide ?',
            ))
            ->add('diet', CheckboxType::class, array(
                'required' => false,
                'label'    => 'Diet ?',
            ))
            ->add('rating', IntegerType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PC\PlatformBundle\Entity\RecipeOption'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pc_platformbundle_recipeoption';
    }


}
