<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class GameSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->setMethod('GET')
            ->add('title', TextType::class, [
            'required'  => false,
            'label'     => false,
            'attr'      => [
                'placeholder' => 'Search',
            ],
        ])
            ->add('categories', EntityType::class, [
                'label' => 'Category',
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                ]
            ])
            ->add('sort_by', HiddenType::class, [
                'constraints' => []
            ])
            ->add('sort_order', HiddenType::class, [
                'constraints' => []
            ])
            ->add('isVisible', HiddenType::class, [
                'data' => '1',
            ]);
        ;
    }
}
