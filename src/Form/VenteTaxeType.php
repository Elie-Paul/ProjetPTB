<?php

namespace App\Form;

use App\Entity\VenteTaxe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteTaxeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbreDeBillet')
            ->add('createAt')
            ->add('updatedAt')
            ->add('billet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VenteTaxe::class,
        ]);
    }
}
