<?php

namespace App\Form;

use App\Entity\CommandeNavette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeNavetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreBillet')
            ->add('etatCommande')
            ->add('dateCommande')
            ->add('dateComnandeValider')
            ->add('dateCommandeRealiser')
            ->add('nombreBilletVendu')
            ->add('nombreBilletRealise')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('billet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandeNavette::class,
        ]);
    }
}