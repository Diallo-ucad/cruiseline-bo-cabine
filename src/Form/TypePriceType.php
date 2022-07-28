<?php

namespace App\Form;

use App\Entity\TypePrice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypePriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fareTypeCode')
            ->add('fareTypeDesc')
            ->add('lang')
            ->add('companyId')
            ->add('timestamp')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypePrice::class,
        ]);
    }
}
