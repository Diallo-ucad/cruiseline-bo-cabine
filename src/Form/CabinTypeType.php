<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\CabinCategory;
use App\Entity\CabinType;
use App\Entity\CabinTypeElement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\TypePrice;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CabinTypeType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$companyId = $options['data']->getCabinCategory()->getId();
		$builder

            ->add('name', TextType::class, ['label' => 'Titre'])
            ->add('position', IntegerType::class, ['label' => 'Position'])

			->add('TypesPrices', EntityType::class, [
				'label' => 'Choisir Types Tarifaires',
				'class' => TypePrice::class,
				'query_builder' => function (EntityRepository $er) use ($companyId) {
					$query = $er->createQueryBuilder('r')
					->andWhere('r.companyId = :val')
					->setParameter('val', $companyId);

					return $query;
				},
				'choice_label' => 'fareTypeDesc',
				'placeholder' => 'Select',
				'multiple' => true,
				'mapped' => true,
				'required' => false,
				'attr' => ['data-placeholder' => 'Choisir Types Tarifaires', 'id' => 'choixTypeTarifaire'],

			])

            ->add('CabinCategory', EntityType::class, [
            	'label' => 'Catégorie cabine',
            	'choice_label' => fn ($category) => $category->getCabinCategoryCode() . ' | ID compagnie : ' . $category->getCompagnieId(),
            	'class' => CabinCategory::class,
            ])

            ->add('codes', CollectionType::class, [
            	'entry_type' => CabinTypeCodeFormType::class,
            	'allow_add' => true,
            	'allow_delete' => true,
            	'entry_options' => ['label' => false],
            	'by_reference' => false, ])

            ->add('elements', CollectionType::class, [
            	'entry_type' => CabinTypeElementType::class,
            	'allow_delete' => true,
            	'allow_add' => true,
            	'entry_options' => ['label' => false],
            	'by_reference' => false,

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
