<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class GameFormType extends AbstractType
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
                        'min' => 2,
                        'max' => 100,
                    ]),
                ],
            ])
            ->add('posterFile', VichFileType::class, [
                'required' => true,
            ])
            ->add('mainCategory', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'multiple' => false,
                'by_reference' => true,
            ])
            ->add('optionalCategory', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'multiple' => false,
                'by_reference' => true,
                'required' => false,
                'empty_data' => null,
            ])
            ->add('description', TextareaType::class, [
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
            ->add('isVirtual', CheckboxType::class, [
                    'label' => 'isVirtual',
                    'required' => false,
                    ])
            ->add('isVisible', CheckboxType::class, [
                    'label' => 'Do you want to make this game visible?',
                    'required' => false,
                    ])
            ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
