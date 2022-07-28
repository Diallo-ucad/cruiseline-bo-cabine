<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\CabinType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\TypePrice;

class CabinTypesType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$companyId = $options['attr']['companyId'];
		$lang = $options['attr']['lang'];
		$builder
            ->add('position', IntegerType::class, ['label' => 'Position'])
            ->add('name', TextType::class, ['label' => 'Titre'])
			->add('TypesPrices', EntityType::class, [
				'label' => 'Choisir Types Tarifaires',
				'class' => TypePrice::class,
				'query_builder' => function (EntityRepository $er) use ($companyId, $lang) {
					$query = $er->createQueryBuilder('r')
					->andWhere('r.companyId = :companyId')
					->andWhere('r.lang = :lang')
					->setParameter('companyId', $companyId, )
					->setParameter('lang', $lang);

					return $query;
				},
				'choice_label' => 'fareTypeDesc',
				'placeholder' => 'Select',
				'multiple' => true,
				'mapped' => true,
				'required' => false,
				'attr' => ['data-placeholder' => 'Choisir Types Tarifaires', 'id' => 'choixTypeTarifaire'],
			])

            ->add('codes', CollectionType::class, [
            	'label' => 'Codes cabines',
            	'attr' => [
            		'class' => 'my-selector',
            	],
            	'entry_type' => CabinTypeCodeFormType::class,
            	'allow_add' => true,
            	'allow_delete' => true,
            	'entry_options' => ['label' => false],
            	'by_reference' => false, ])

            ->add('elements', CollectionType::class, [
            	'entry_type' => CabinTypeElementType::class,
            	'allow_add' => true,
            	'allow_delete' => true,
            	'entry_options' => ['label' => false],
            	'by_reference' => false,
            	'label' => 'Liste Elements',
            	'attr' => [
            		'class' => 'my-selector',
            	],
            ])

        ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => CabinType::class,
		]);
	}
}
