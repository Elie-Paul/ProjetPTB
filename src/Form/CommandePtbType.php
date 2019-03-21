<?php

namespace App\Form;

use App\Entity\CommandePtb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandePtbType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreBillet')
            ->add('etatCommande')
            ->add('dateCommande')
            ->add('dateCommandeValider')
            ->add('dateCommandeRealiser')
            ->add('updatedAt')
            ->add('createdAt')
            ->add('billet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandePtb::class,
        ]);
    }
}
