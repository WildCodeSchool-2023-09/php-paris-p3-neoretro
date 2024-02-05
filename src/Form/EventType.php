<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Event name',
                'attr' => [
                    'placeholder' => 'Event name'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Describe the event',
                    'rows' => 3
                ]
            ])
            ->add('startDate', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label' => 'Start date & time',
            ])
            ->add('endDate', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label' => 'End date & time',
            ])
            ->add('isVisible', CheckboxType::class, [
                'label' => 'Display event now?',
                'required' => false,
            ])
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'title',
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
