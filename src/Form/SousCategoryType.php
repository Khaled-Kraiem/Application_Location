<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\SousCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SousCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Name ....',
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description ....',
                    'class' => 'form-control',
                ]
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'attr' => [
                    'id' => 'input-file-now-custom-',
                    'class' => 'file-upload'
                ]
            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'description',
                'placeholder' => 'Sélectionnez une catégorie',
                // 'multiple' => false,
                // 'expanded' => true,
                'label' => false,
                'attr' => ['class' => 'mdb-select md-form',],
                'mapped' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousCategory::class,
        ]);
    }
}
