<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\CabinCategory;
use App\Entity\CabinType;
use App\Entity\ForfaitConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ForfaitConfigType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
            ->add('companyId')
            ->add('bateau_id')
            ->add('port_id')

            ->add('cabinCategory', EntityType::class, [
            	'class' => CabinCategory::class,

            	'choice_label' => 'cabinCategoryTexte',
            	'disabled' => false,
            	'mapped' => true,
            ])
            ->add('cabinType', EntityType::class, [
            	'class' => CabinType::class,

            	'choice_label' => 'name',
            	'disabled' => false,
            	'mapped' => true,
            ]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => ForfaitConfig::class,
		]);
	}
}
