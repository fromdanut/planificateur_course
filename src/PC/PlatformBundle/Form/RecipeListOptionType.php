<?php

namespace PC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RecipeListOptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword', SearchType::class, array('required' => false))
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
            ->add('rating', IntegerType::class)
             ->add('styles', EntityType::class, array(
                       'class'        => 'PCPlatformBundle:Category',
                       'choice_label' => 'name',
                       'multiple'     => true,
                       'required'     => false,
                       'label'        => 'note minimum',
                     ))
             ->add('save', SubmitType::class, array(
                 'label' => 'rechercher'
             ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PC\PlatformBundle\Entity\RecipeListOption'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pc_platformbundle_recipelistoption';
    }


}
