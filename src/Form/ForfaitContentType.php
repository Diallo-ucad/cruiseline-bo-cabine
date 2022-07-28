<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\Forfait;
use App\Entity\ForfaitContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ForfaitContentType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
            ->add('adult_only', CheckboxType::class, [
                'label' => 'Reservé aux adultes',
                'required' => false,
            ])
            ->add('langue')
            ->add('position')
            ->add('description')
        ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => ForfaitContent::class,
		]);
	}
}
