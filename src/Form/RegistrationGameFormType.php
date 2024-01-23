<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;

class RegistrationGameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Title',
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
            ->add('posterFile', VichFileType::class, [
                'required' => false,
            ])
            ->add('description', TextType::class, [
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
            // ->add('category', EntityType::class, [
            //     'class' => Category::class,
            //     'choice_label' => 'label',
            //     'multiple' => false,
            //     'expanded' => true,
            //     'by_reference' => true,
            // ])
            ->add('isVirtual', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-add-game checked'
                    ],
                    'label' => 'isVirtual',
                    'required' => false,
                    ])
            ->add('isVisual', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-add-game checked'
                    ],
                    'label' => 'isVisual',
                    'required' => false,
                    ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class
        ]);
    }
}
