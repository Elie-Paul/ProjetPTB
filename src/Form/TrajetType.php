<?php

namespace App\Form;

use App\Entity\Trajet;
use App\Entity\Lieux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'libelle'
            ])
            ->add('arrivee', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
