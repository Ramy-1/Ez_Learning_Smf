<?php

namespace App\Form;

use App\Entity\Reponses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\File;

class ReponsesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextType::class, ['attr' => ['placeholder' => "Reponse" ,'class' => "form-control"],
            'constraints' => [          
                new Regex([
                    "pattern"=>"/^([a-zA-Z])/m",
                    "message"=>'Il faut entree un contenu',
                    ]
                ),
            ],'required' => false])
            ->add('isCorrect', CheckboxType::class, ['attr' => ['class' => "form-check-input"],'required' => false])
            ->add('note', NumberType::class, ['attr' => ['placeholder' => "Note" ,'class' => "form-control"],'required' => false
            ,'constraints' => [          
                new Regex([
                    "pattern"=>"/^([0-9])/m",
                    "message"=>'Il faut entree un chiffre',
                    ]
                ),
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponses::class,
        ]);
    }
}
