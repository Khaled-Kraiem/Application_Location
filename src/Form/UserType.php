<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'exemple ...',
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un e-mail',
                    ]),
                ],
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'exemple@exemple.exemple',
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Particulier' => 'Particulier',
                    'Société' => 'Société'
                ],
                'multiple' => false,
                // 'required' => true,
                //'label' => true,
                'placeholder' => 'Vous été ?',
                'attr' => ['class' => 'mdb-select md-form'],
            ])
            ->add('zip', TextType::class, [
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'XXXX',
                ]
            ])
            ->add('cin', TextType::class, [
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'CIN n°',
                ]
            ])
            ->add('matricule', TextType::class, [
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Matricule fiscal n°',
                ]
            ])
            ->add('telephone', TextType::class, [
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Télephone n°',
                ]
            ])
            ->add('adresse', TextareaType::class, [
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Télephone n°',
                ]
            ])
            ->add('city', ChoiceType::class, [
                'choices' => [
                    'Ariana' => 'Ariana',
                    'Béja' => 'Béja',
                    'Ben Arous' => 'Ben Arous',
                    'Bizerte' => 'Bizerte',
                    'Gabes' => 'Gabes',
                    'Gafsa' => 'Gafsa',
                    'Jendouba' => 'Jendouba',
                    'Kairouan' => 'Kairouan',
                    'Kasserine' => 'Kasserine',
                    'Kebili' => 'Kebili',
                    'La Manouba' => 'La Manouba',
                    'Le Kef' => 'Le Kef',
                    'Mahdia' => 'Mahdia',
                    'Médenine' => 'Médenine',
                    'Monastir' => 'Monastir',
                    'Nabeul' => 'Nabeul',
                    'Sfax' => 'Sfax',
                    'Sidi Bouzid' => 'Sidi Bouzid',
                    'Siliana' => 'Siliana',
                    'Sousse' => 'Sousse',
                    'Tataouine' => 'Tataouine',
                    'Tozeur' => 'Tozeur',
                    'Tunis' => 'Tunis',
                    'Zaghouan' => 'Zaghouan'
                ],
                'multiple' => false,
                'placeholder' => 'Sélectionnez votre ville',

                // 'required' => false,
                //'label' => true,
                'attr' => ['class' => 'mdb-select md-form']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
