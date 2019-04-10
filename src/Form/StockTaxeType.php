<?php

namespace App\Form;

use App\Entity\StockTaxe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockTaxeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbre')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('billet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockTaxe::class,
        ]);
    }
}
