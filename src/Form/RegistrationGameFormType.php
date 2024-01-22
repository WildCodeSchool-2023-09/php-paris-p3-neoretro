<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationGameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('Title', TextType::class, [
                    'attr' => [
                        'placeholder' => 'title'
                        ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter the title',
                        ]),
                        new Length([
                            'min' => 2,
                            'max' => 100,]),],])
                ->add('Description', TextType::class, [
                    'attr' => [
                        'placeholder' => 'description'
                        ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter the description',]),
                        new Length([
                            'min' => 2,
                            'max' => 200,
                            'minMessage' => 'Your description should be at least {{ limit }} characters',
                            'maxMessage' => 'Your description should not be longer than {{ limit }} characters',]),],])
                ->add('Poster', EmailType::class, [
                    'attr' => [
                        'placeholder' => 'poster'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter your poster',
                        ]),],])
                ->add('isVirtual', CheckboxType::class, [
                    'attr' => [
                        'placeholder' => 'Virtual'
                        ],
                        'label' => 'Virtual',
                        'required' => false,
                        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class
        ]);
    }
}
