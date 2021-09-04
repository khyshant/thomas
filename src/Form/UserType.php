<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function  buildform(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Adresse email',
                    'invalid_message' => "cet email non vallide",
                    'required'  => true
                ])
            ->add(
                'username',
                TextType::class,
                [
                    'label'     => "Nom d'utilisateur",
                    'invalid_message' => "nom d'utilisateur non valide",
                    'required'  => true
                ]
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passes ne sont pas identiques',
                    'required' => true,
                    'first_options'  => [
                        'label' => 'Mot de passe'
                    ],
                    'second_options' => [
                        'label' => 'Confirmez lle mot de passe'
                    ],
                ]
            )
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => [
                        'Utilisateur' => "USER",
                        'Admin' => "ADMIN"
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'label' => "Rôle",
                    'required' => true,
                    'empty_data' => "USER"
                ]
            )->add('save', SubmitType::class, ['label' => 'Soumettre']);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", User::class);
    }
}