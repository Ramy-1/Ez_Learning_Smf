<?php

namespace App\Form;

use App\Entity\Test;
use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, ['attr' => ['placeholder' => "Titre de Test" ,'class' => "form-control"] ,'constraints' => [          
                new Regex([
                    "pattern"=>"/^([a-zA-Z])/m",
                    "message"=>'Your title must contain characters',
                    ]
                ),
            ]])
           
            ->add('description', CKEditorType::class, array(  
                
                'plugins' => array(
                    'mathjax' => array(
                        'path'     => '/bundles/fosckeditor/plugins/mathjax',
                        'filename' => 'plugin.js',
                    ),
                ),
        ))
            ->add('imageFile',FileType::class,['required'=>false ,'constraints' => [
                new File([
                'maxSize' => '2M',
                'mimeTypes' => [
                    'image/png',
                    'image/jpg', 
                    'image/jpeg',            
                        ],
                    'mimeTypesMessage' => 'Please upload a valid image',
                    ])]])
            ->add('cours',EntityType::class, [
                'class' => Cours::class,
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }

    
}
