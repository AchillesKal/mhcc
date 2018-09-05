<?php

namespace App\Form;

use App\Entity\CustomerJob;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('zipcode')
            ->add('city')
            ->add('description')
            ->add('deliveryDate', DateTimeType::class, array(
                'widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd H:i'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CustomerJob::class,
        ]);
    }
}
