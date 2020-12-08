<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control validate',
                    'placeholder' => 'Nom & Prénom',
                    'id' => 'Form-t'
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un e-mail',
                    ]),
                ],
                'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control validate',
                    'placeholder' => 'exemple@exemple.exemple',
                    'id' => 'Form-e'
                ]
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control validate',
                    'placeholder' => 'Mot de passe',
                    'id' => 'Form-p'
                ]
            ])
            ->add('confirm_password', PasswordType::class, [
                'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control validate',
                    'placeholder' => 'Confirmer le mot de passe',
                    'id' => 'Form-pp'
                ]
            ])
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'Utilisateur' => 'ROLE_USER',
            //         'Locateur' => 'ROLE_LOCATEUR',
            //         'Administrateur' => 'ROLE_ADMIN'
            //     ],
            //     'multiple' => true,
            //     'required' => false,
            //     //'label' => true,
            //     // 'placeholder' => 'Sélectionnez les roles',
            //     'attr' => ['class' => 'mdb-select md-form'],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
