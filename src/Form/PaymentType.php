<?php

namespace App\Form;

use App\Entity\Abonnement;
use App\Entity\Payment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('mois')
            ->add('mois', ChoiceType::class,[
                'choices' => $this->getChoices()
            ])
            ->add('abonnement', EntityType::class, [
                'class' => Abonnement::class,
            ]);
        /***
         * 'choices' => [
        'janvier' => 'Janvier',
        ],
        'placeholder' => 'Selectionner au moin un champ',
        'expanded' => false,
        'required' => true,
        'multiple' => true
         */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Payment::MOIS;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
}
