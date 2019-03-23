<?php

namespace App\Form;

use App\Entity\Abonnement;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'required' => true,                
                'label' => "Image",
                'attr' => [                    
                    'class' => 'form-control',
                    'required' => true                  
                    ] 
            ])
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('telephone', TextType::class, [
                'attr' => [
                    'placeholder' => "+221"
                ]
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
//                'choice_label' => 'libelle',
                'empty_data'  => null,
                'placeholder' => "Veuillez choisir un type d'abonnement"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
