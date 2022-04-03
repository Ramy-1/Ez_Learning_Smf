<?php

namespace App\Form;

use App\Entity\Questions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextType::class, ['attr' => ['placeholder' => "Contenu de question" ,'class' => "form-control"]])
            ->add('description', CKEditorType::class, array(  
                
                'plugins' => array(
                    'mathjax' => array(
                        'path'     => '/bundles/fosckeditor/plugins/mathjax',
                        'filename' => 'plugin.js',
                    ),
                ),
        ))
            ->add('supportFile')
            ->add('test')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
        ]);
    }
}
