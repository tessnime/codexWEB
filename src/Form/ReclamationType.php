<?php

namespace App\Form;

use App\Entity\Reclamation;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use function Sodium\add;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('objetReclamation',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('message' ,TextType::class,[
        'attr' => [
            'class' => 'form-control'
        ]

    ])
            ->add('dateReclamation',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]

            ])

            ->add('Categorie',EntityType::class,[
        'mapped'=>false,
        'class'=> Categorie::class,
        'choice_label'=>'typeReclamation',
        'placeholder'=>'typeReclamation',
        'label'=>'typeReclamation'])

            ->add('captcha', Recaptcha3Type::class, [

                'action_name' => 'homepage',
            ]);



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
