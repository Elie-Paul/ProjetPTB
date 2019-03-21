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


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'required' => true,
                'label' => "L'image doit être de type jpeg"
            ])
            ->add('nom')            
            ->add('prenom')
            ->add('email')
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Superviseur' => 'ROLE_SUPER_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true
            ])            
            ->add('password',PasswordType::class)
            ->add('confirme_password',PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
