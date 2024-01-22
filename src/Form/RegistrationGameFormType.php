<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
                        'placeholder' => 'Title'
                        ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter the title',
                        ]),
                        new Length([
                            'min' => 2,
                            'max' => 100,]),],])
                ->add('posterFile', VichFileType::class, [
                        'required' => false,
                //         // 'allow_delete' => true,
                //         // 'download_uri' => true,
                ])
                ->add('description', TextType::class, [
                    'attr' => [
                        'placeholder' => 'Description'
                        ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter the description',]),
                        new Length([
                            'min' => 2,
                            'max' => 200,
                            'minMessage' => 'Your description should be at least {{ limit }} characters',
                            'maxMessage' => 'Your description should not be longer than {{ limit }} characters',]),],]);
                // ->add('Poster', EmailType::class, [
                //     'attr' => [
                //         'placeholder' => 'Poster'],
                //     'constraints' => [
                //         new NotBlank([
                //             'message' => 'Please enter your poster',
                //         ]),],]);
                // ->add('Virtual', TextType::class, [
                //     'attr' => [
                //         'placeholder' => 'virtual'
              //         ],]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class
        ]);
    }
}
