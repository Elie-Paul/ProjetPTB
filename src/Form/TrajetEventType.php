<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\SectionEvent;
use App\Entity\TrajetEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depart')
            ->add('arrivee')
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'required' => true,
                'choice_label' => 'libelle'
            ])
            ->add('section', EntityType::class, [
                'class' => SectionEvent::class,
                'required' => true,
                'choice_label' => 'libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrajetEvent::class,
        ]);
    }
}
