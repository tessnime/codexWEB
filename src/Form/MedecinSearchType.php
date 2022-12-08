<?php

namespace App\Form;

use App\Entity\MedecinSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class MedecinSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomMed', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Nom du medecin'],
            ])
            ->add('specialiteMed', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Specialite du medecin'],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MedecinSearch::class,
            'method' => 'get',
            'csrf_protection' => false 
        ]);
    }

    public function getBlockPrefix(){
        return '';
    }
}
