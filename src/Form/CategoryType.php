<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom',
                ]
            ])
            ->add('description', TextareaType::class, [
                // 'required' => true,
                //'label' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                ]
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'attr' => [
                    'id' => 'input-file-now-custom-2',
                    'class' => 'file-upload'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
