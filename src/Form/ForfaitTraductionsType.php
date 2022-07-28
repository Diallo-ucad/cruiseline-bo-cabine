<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\Forfait;
use App\Entity\ForfaitTraductions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ForfaitTraductionsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
            ->add('lang')
            ->add('forfaitTitle')
            ->add('forfait', EntityType::class, [
            	// looks for choices from this entity
            	'class' => Forfait::class,
            	'choice_label' => 'forfait_titre',
            	'disabled' => false,
            	// used to render a select box, check boxes or radios
            	// 'multiple' => true,
            	// 'expanded' => true,
            ])
        ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => ForfaitTraductions::class,
		]);
	}
}
