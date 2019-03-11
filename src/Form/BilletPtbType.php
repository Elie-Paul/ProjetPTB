<?php

namespace App\Form;

use App\Entity\BilletPtb;
use App\Entity\Guichet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletPtbType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroDernierBillets')
            ->add('ptb')
            ->add('guichet', EntityType::class, [
                'class' => Guichet::class,
                'choice_label' => 'code'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BilletPtb::class,
        ]);
    }
}
