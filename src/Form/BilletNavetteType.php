<?php

namespace App\Form;

use App\Entity\BilletNavette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletNavetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroDernierBillet')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('navette')
            ->add('guichet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BilletNavette::class,
        ]);
    }
}
