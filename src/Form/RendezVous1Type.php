<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RendezVous1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateRv',DateType::class,[
                'widget'=>'single_text',
                'placeholder' => 'Select a value',
                
            ])
            ->add('heureRv', ChoiceType::class, 
            [
                'placeholder' => 'Choisissez_heure',
                'choices'  => [
                    '9:00' => '9:00',
                    '9:30' => '9:30',
                    '10:00' => '10:00',
                    '10:30' => '10:30',
                    '11:00' => '11:00',
                    '11:30' => '11:30',
                    '14:00' => '14:00',
                    '14:30' => '14:30',
                    '15:00' => '15:00',
                    '15:30' => '15:30',
                    '16:00' => '16:00',
                    '16:30' => '16:30',
                    
                    
                ],])
            ->add('etat', ChoiceType::class, 
            [
                'placeholder' => 'etat du rendez-vous',
                'choices'  => [
                    'Annulation' => 'Annulation',
                    'Confirmation' => 'Confirmation',
                    'En Attente' => 'En Attente',
                    'Changer la date du rendez-vous s\'il vous plait' => 'Changer la date du rendez-vous s\'il vous plait',
                    
                    
                ],])
            //->add('idPatient')
            //->add('idMedecin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
