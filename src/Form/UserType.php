<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Type;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [                
                'label' => "Image",
                'attr' => [                    
                    'class' => 'form-control',
                    'required' => true                  
                    ]             
            ])
            ->add('nom')            
            ->add('prenom')
            ->add('email')
            ->add('username',TextType::class,[
                'required' => true,
                'label'=> "Utilisateur"
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [                    
                    'utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Superviseur' => 'ROLE_SUPER_ADMIN',
                ],
                'label'=> "Rôles",
                'expanded' => false,
                'multiple' => true
            ])            
            ->add('password',PasswordType::class,[
                'label'=> "Mot de Passe",
                'mapped' => false,
            ])
            ->add('confirme_password',PasswordType::class,[
                'label'=> "Confirmation de Mot de Passe",
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
