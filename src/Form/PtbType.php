<?php

namespace App\Form;

use App\Entity\Ptb;
//use App\Entity\Guichet;
use App\Entity\Section;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PtbType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trajet')
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'libelle'
            ])
        ;

       /* 
       
            ->add('guichet', EntityType::class,[
                'class' => 'App\Entity\Guichet',
                'placeholder' => 'Guichet',
                'mapped' => false,
            ])
       
       $builder->get('guichet')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
            }
        );*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ptb::class,
        ]);
    }
}
