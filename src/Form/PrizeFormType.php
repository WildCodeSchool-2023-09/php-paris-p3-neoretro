<?php

namespace App\Form;

use App\Entity\Prize;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PrizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('label', TextType::class, [
            'attr' => [
                'placeholder' => 'Label',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter the title',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 100,
                ]),
            ],
        ])
        ->add('description', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Description',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter the description',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 200,
                    'minMessage' => 'Your description should be at least {{ limit }} characters',
                    'maxMessage' => 'Your description should not be longer than {{ limit }} characters',
                ]),
            ],
        ])
            ->add('posterFile', VichFileType::class, [
                'attr' => [
                    'data-controller' => 'mydropzone',
                    'placeholder' => 'Drag & Drop picture',
                ],
                'required' => true,
            ])
            ->add('value', TextType::class, [
                'attr' => [
                    'placeholder' => 'Value',
                    'required' => true,
                ]  
            ])
            ->add('quantity', TextType::class, [
                'attr' => [
                    'placeholder' => 'Stock',
                    'required' => false,
                ]  
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