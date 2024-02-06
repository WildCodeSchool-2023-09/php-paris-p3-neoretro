<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Game;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'attr' => ['placeholder' => 'firstname'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your first name',]),
                new Length([
                    'min' => 2,
                    'max' => 100,
                    'minMessage' => 'Your first name should be at least {{ limit }} characters',
                    'maxMessage' => 'Your first name should not be longer than {{ limit }} characters',]),],])
        ->add('lastname', TextType::class, [
            'attr' => ['placeholder' => 'lastname'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your last name',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 100,
                    'minMessage' => 'Your last name should be at least {{ limit }} characters',
                    'maxMessage' => 'Your last name should not be longer than {{ limit }} characters',]),],])
        ->add('email', EmailType::class, [
            'attr' => ['placeholder' => 'email'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your email address',
                ]),
                new Email([
                    'message' => 'Please enter a valid email address',]),],])
        ->add('username', TextType::class, [
            'attr' => ['placeholder' => 'username'],
            'constraints' => [
                new NotBlank(['message' => 'Please enter a username',]),
                new Length([
                    'min' => 3,
                    'max' => 180,
                    'minMessage' => 'Your username should be at least {{ limit }} characters',
                    'maxMessage' => 'Your username should not be longer than {{ limit }} characters',]),],])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,]),],]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, Game::class
        ]);
    }
}
