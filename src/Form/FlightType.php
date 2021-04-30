<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Flight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('price', NumberType::class, [
                'label' => 'Prix du vol'
            ])
            ->add('schedule', TimeType::class, [
                'label' => 'Horaires',
                'hours' => range(5,21)
            ])
            ->add('reduction', CheckboxType::class, [
                'label' => 'Réduction de 10% ?'
            ])
            ->add('seat', IntegerType::class, [
                'label' => 'Places disponibles'
            ])
            ->add('departure', EntityType::class, [
                "class"=> City::class,
                "choice_label"=> "name",
                "label"=> "Departure"
            ])
            ->add('arrival', EntityType::class, [
                "class"=> City::class,
                "choice_label"=> "name",
                "label"=> "Arrival"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Flight::class,
            'required' => false
        ]);
    }
}
