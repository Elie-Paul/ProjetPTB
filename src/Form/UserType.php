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
use Symfony\Component\HttpFoundation\File\File;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('nom')            
            ->add('prenom')
            ->add('email')
            ->add('username',TextType::class,[
                'required' => true,
                'label'=> "Utilisateur"
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [                    
                    'Billetteur' => 'ROLE_BILLETTEUR',
                    'Administrateur' => 'ROLE_ADMINISTRATEUR',
                    'Superviseur' => 'ROLE_SUPERVISEUR',
                    'Validateur' => 'ROLE_VALIDATEUR',
                    'Responsable Vente' => 'ROLE_RESPONSABLE_DE_VENTE',
                ],                
                'label'=> "Rôles",
                'expanded' => false,
                'multiple' => true
            ])  
            
            ->add('active')
            ->add('password',PasswordType::class,[
                'label'=> "Mot de Passe",
                'required' => true
                
            ])
            ->add('confirme_password',PasswordType::class,[
                'label'=> "Confirmation de Mot de Passe",
                'required' => true
                
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
