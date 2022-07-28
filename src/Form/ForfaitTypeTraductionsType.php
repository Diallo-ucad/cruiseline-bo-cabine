<?php

namespace App\Form;


use App\Entity\ForfaitTypeTraductions;
use App\Entity\TypeForfait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForfaitTypeTraductionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lang')
            ->add('forfaitTypeTitle')
            ->add('forfaitType', EntityType::class, [
                'class' => TypeForfait::class,
                'choice_label' => 'titre',
                'disabled' => false,
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ForfaitTypeTraductions::class,
        ]);
    }
}
