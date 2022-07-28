<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\TypeForfait;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TypeForfaitType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
            ->add('titre')
            ->add('code', HiddenType::class, [
            	'data' => '10',
                'required' => false])
            ->add('actif', CheckboxType::class, [
                'required' => false,
                'label' => 'Activer'])
        ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => TypeForfait::class,
		]);
	}
}
