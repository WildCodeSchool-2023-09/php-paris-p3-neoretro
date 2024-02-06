<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter the title',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 50,
                        'maxMessage' => 'Your title should not be longer than {{ limit }} characters',
                    ]),
                ]
            ])
            ->add('opinion', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your opinion',
                    ]),
                ],
            ])
            ->add('note', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                ],
                'constraints' => [
                    new Assert\Range([
                        'min' => 0,
                        'max' => 5,
                        'notInRangeMessage' => 'The value must be between {{ min }} and {{ max }}.',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
