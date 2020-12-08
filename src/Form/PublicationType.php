<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Publication;
use App\Entity\SousCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                ],
                'required' => false,
                'label' => false,
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Description ....',
                    'class' => 'form-control',
                ],
                'required' => false,
                'label' => false,
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'attr' => [
                    'id' => 'input-file-now-custom-2',
                    'class' => 'file-upload'
                ],
                'label' => false,

            ])

            ->add('sousCategory', EntityType::class, [
                'class' => SousCategory::class,
                'choice_label' => 'description',
                'placeholder' => 'Sélectionnez type de produit',
                'attr' => ['class' => 'mdb-select md-form',],
                // 'multiple' => false,
                // 'expanded' => true,
                'mapped' => true,
                'label' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
