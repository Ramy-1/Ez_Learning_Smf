<?php

namespace App\Form;

use App\Entity\Questions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\File;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextType::class, ['attr' => ['placeholder' => "Contenu de question" ,'class' => "form-control"],'constraints' => [          
                new Regex([
                    "pattern"=>"/^([a-zA-Z])/m",
                    "message"=>'Your question content must contain characters',
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
            ->add('supportFile',FileType::class, [ 'constraints' => [
                new File([
                'maxSize' => '2M',
                'mimeTypes' => [
                    'application/pdf',
                    'application/x-pdf',             
                        ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])],"required"=>false])
           # ->add('test')
           ->add('type', ChoiceType::class, [
            'choices'  => [
                'Choix Multiple' => "Multiple",
                'Un seul choix' => "seul choix",
                
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
        ]);
    }
}
