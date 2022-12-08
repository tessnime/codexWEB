<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ChangeDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date',DateTimeType::class,[
            'attr'   => ['min' =>( new \DateTime('@'.strtotime('now')))->format('Y-m-d H:i:s')],
            'date_widget'=>'single_text',
            'placeholder' => 'Select a value',
            'hours'=>[8,9,10,11,12,13,14,15,16,17],
            'date_label' => 'Starts On',
            'time_label' => 'Starts On',
     
            ])
        ->add('confirmer_rendez_vous',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
