<?php

namespace App\Form;

use App\Entity\Societe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class SocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idsoc',TextType::class,['attr'=>["class"=>"form-control"]])
            ->add('nom',TextType::class,['attr'=>["class"=>"form-control"]])
            ->add('email',EmailType::class,['attr'=>["class"=>"form-control"]])
            ->add('adresse',TextType::class,['attr'=>["class"=>"form-control"]])
            ->add('imgsoc',FileType::class, [
                'label'=>false,
                'multiple'=>false,
                'mapped'=>false,
                'required'=>false
            ])
            ->add('mdpsoc',PasswordType::class,['attr'=>["class"=>"form-control"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Societe::class,
        ]);
    }
}
