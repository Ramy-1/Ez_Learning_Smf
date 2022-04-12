<?php

namespace App\Form;

use App\Entity\Evenement;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\DateType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idorg')
            ->add('description')
            ->add('date', DateType::class, [
                'placeholder' => [

                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'format' => 'yyyy-MM-dd',

                ],
                'input'  => 'datetime'
            ])
            ->add('heure')
            ->add('lien')
            // ->add('imgev',FileType::class, array('data_class' => null))
            ->add('nbrparticipant')
            ->add('iduni');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
