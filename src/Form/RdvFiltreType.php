<?php

namespace App\Form;

use App\Entity\RdvFiltre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RdvFiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('etat', ChoiceType::class, 
        [
            'placeholder' => 'etat du rendez-vous',
            'choices'  => [
                'Annulation' => 'Annulation',
                'Confirmation' => 'Confirmation',
                'En Attente' => 'En Attente',
                'Changer la date du rendez-vous s\'il vous plait' => 'Changer la date du rendez-vous s\'il vous plait',
                
                
            ],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RdvFiltre::class,
            'method' => 'get',
            'csrf_protection' => false 
        ]);
    }

    public function getBlockPrefix(){
        return '';
    }
}
