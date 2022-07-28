<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\Forfait;
use App\Entity\TypeForfait;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForfaitType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$selectedTypeForfait = $options['attr'][0];

		$builder
        ->add('type_forfait', EntityType::class, [
        	// looks for choices from this entity
        	'class' => TypeForfait::class,
        	'choice_label' => fn ($typeForfait) => $typeForfait,
        	'disabled' => true,
        	'data' => $selectedTypeForfait,
            'label' => 'Type'
        	// used to render a select box, check boxes or radios
        	// 'multiple' => true,
        	// 'expanded' => true,
        ])
            ->add('forfait_titre', null, [
                    'label' => 'Titre'
                ]
            )
            ->add('companyId',  null, [
                'label' => 'Compagnie'
            ])
            ->add('actif', CheckboxType::class, [
                'required' => false,
                'label' => 'Activer'
            ])
            ->add('type_prestation_id', HiddenType::class)
        ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Forfait::class,
		]);
	}
}
