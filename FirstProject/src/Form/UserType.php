<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormView;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, array(
                'label' => 'Email ',
                'attr' => array(
                    'placeholder' => 'Email'
                )
            ))
            // ->add('roles')
            ->add('roles', ChoiceType::class, [
                // 'required' => true,
                'expanded' => false,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Etudiant' => 'ROLE_ETUDIANT',
                    'Recruteur' => 'ROLE_RECRUTEUR',
                    'Ensiegnant' => 'ROLE_ENSIEGNANT',
                    'Universite' => 'ROLE_UNIVERSITE',
                    'Societe' => 'ROLE_SOCIETE',
                ],
                // 'expanded' => true
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'Password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 69,
                    ]),
                ],
            ])
            ->add(
                'name',
                null,
                [
                    'attr' => ['placeholder' => 'Name'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a Name',
                        ]),
                        new Length([
                            'min' => 4,
                            'minMessage' => 'Your Name should be at least {{ limit }} characters',
                            'max' => 69,
                        ]),
                    ],
                ]
            )
            ->add(
                'lastName',
                null,
                [
                    'attr' => ['placeholder' => 'Last Name'],

                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a LastName',
                        ]),
                        new Length([
                            'min' => 4,
                            'minMessage' => 'Your LastName should be at least {{ limit }} characters',
                            'max' => 69,
                        ]),
                    ],
                ]
            )
            // ->add('faceID')
            // ->add('isVerified')
            ->add('captcha', ReCaptchaType::class, [
                'mapped' => false,
                'type' => 'invisible' // (invisible, checkbox)
            ]);;;
        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // 'type', 'invisible'
        ]);
        // ->setAllowedValues('type', ['checkbox', 'invisible']);
    }
}
