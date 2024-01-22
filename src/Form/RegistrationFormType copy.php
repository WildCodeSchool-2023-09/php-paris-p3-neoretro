<?php

/*
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Firstname', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your first name',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 100,
                    'minMessage' => 'Your first name should be at least {{ limit }} characters',
                    'maxMessage' => 'Your first name should not be longer than {{ limit }} characters',]),],])
        ->add('Lastname', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your last name',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 100,
                    'minMessage' => 'Your last name should be at least {{ limit }} characters',
                    'maxMessage' => 'Your last name should not be longer than {{ limit }} characters',]),],])
        ->add('PhoneNumber', TelType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your phone number',
                ]),
                new Regex([
                    'pattern' => '/^[0-9]{10}$/',
                    'message' => 'Please enter a valid phone number (10 digits)',]),],])
        ->add('Email', EmailType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your email address',
                ]),
                new Email([
                    'message' => 'Please enter a valid email address',]),],])
        ->add('Adress', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your address',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 20,
                    'minMessage' => 'Your address should be at least {{ limit }} characters',
                    'maxMessage' => 'Your address should not be longer than {{ limit }} characters',]),],])
        ->add('City', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your city',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 5,
                    'minMessage' => 'Your city name should be at least {{ limit }} characters',
                    'maxMessage' => 'Your city name should not be longer than {{ limit }} characters',]),],])
        ->add('ZipCode', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your ZIP code',
                ]),
                new Regex([
                    'pattern' => '/^[0-9]{5}$/',
                    'message' => 'Please enter a valid ZIP code (5 digits)',]),],])
        ->add('username', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a username',
                ]),
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
            'data_class' => User::class,
        ]);
    }
}
*/
