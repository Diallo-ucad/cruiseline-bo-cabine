<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\CabinCategory;
use App\Entity\CabinType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CabinCategoryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$companyId = ($options['data']->getCompagnieId());
		$lang = ($options['data']->getLangue());
		$builder
            ->add('compagnie_id', IntegerType::class, ['label' => 'ID compagnie'])
            ->add('bateauId', TextType::class, ['label' => 'ID bateau'])
            ->add('langue', TextType::class, ['label' => 'Langue', 'empty_data' => 'fr'])
            ->add('CabinCategoryCode', IntegerType::class, ['label' => 'Numéro catégorie cabine'])
            ->add('CabinCategoryTexte', TextType::class, ['label' => 'Titre catégorie cabine'])
            ->add('CabinTypes', CollectionType::class, [
            	'entry_type' => CabinTypesType::class,
            	'allow_add' => true,
            	'allow_delete' => true,
            	'entry_options' => [
            		'label' => false,
            		'attr' => [
            			'companyId' => $companyId,
            			'lang' => $lang,
            		],
            	],
            	'by_reference' => false,
            	'label' => 'Type cabine',
            	'attr' => [
            		'class' => 'my-selector',
            	],
            	'required' => false,
            ])

        ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => CabinCategory::class,
		]);
	}
}
