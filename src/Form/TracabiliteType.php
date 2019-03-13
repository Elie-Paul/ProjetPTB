<?php

namespace App\Form;

use App\Entity\Tracabilite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TracabiliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('motif')
            ->add('numDepart')
            ->add('numFin')
            ->add('user')
            ->add('ptb')
            ->add('navette')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tracabilite::class,
        ]);
    }
}
