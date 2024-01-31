<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Game;
use App\Entity\Prize;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('description')
            ->add('startDate', DateTimeType::class)
            ->add('endDate')
            ->add('isVisible')
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'title',
            ])
            ->add('firstPrize', EntityType::class, [
                'class' => Prize::class,
                'choice_label' => 'id',
            ])
            ->add('secondPrize', EntityType::class, [
                'class' => Prize::class,
                'choice_label' => 'id',
            ])
            ->add('thirdPrize', EntityType::class, [
                'class' => Prize::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
