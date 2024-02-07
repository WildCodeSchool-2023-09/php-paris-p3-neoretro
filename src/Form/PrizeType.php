<?php

namespace App\Form;

use App\Entity\Prize;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prizeLabel')
            ->add('description')
            ->add('picture')
            ->add('value')
            ->add('quantity')
            ->add('slug')
            ->add('winners', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'id',
            'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prize::class,
        ]);
    }
}
