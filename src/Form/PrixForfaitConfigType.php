<?php

declare(strict_types=1);
namespace App\Form;

use App\Entity\Forfait;
use App\Entity\ForfaitConfig;
use App\Entity\PrixForfaitConfig;
use App\Entity\TypeForfait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PrixForfaitConfigType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
        $selectedForfaitConfig = $options['attr'][0];
       // $allForfaitsConfigs = $options['attr'][1];

		$builder
            ->add('forfaitConfig', EntityType::class, [
                'class' => ForfaitConfig::class,
                'choice_label' => function($forfaitConfig){
                    return $forfaitConfig;
                },
                'label' => 'Configuration',
                'label_attr' => ['id' => 'forfaitConfigLabel'],
                'disabled' => true,
                'attr' => ['id' => 'forfaitConfig'],
                'data' => $selectedForfaitConfig,
                'required' => true,


            ])
            ->add('actif' , CheckboxType::class, [
                'attr' => ['id' => 'actif'],
                'label' => 'Activer'
            ])
            ->add('tarifSemaine', TextType::class, [
                'attr' => ['id' => 'tarifSemaine'],
                'required' => false,
            ])
            ->add('tarifJour', TextType::class, [
                'attr' => ['id' => 'tarifJour'],
                'required' => false,
            ])
            ->add('currency', ChoiceType::class, [
                'choices'  => [
                    'Euro' =>  '€',
                    'US Dollars' => '$' ,
                    'Rouble' => '₽',
                    'Real' => 'R$',
                    'Franc Suisse' => 'CHF',
                    'Peso (MXN)' => 'MXN$',
                    'Dollars Canadienne' => '$ca'
                ],
                'attr' => ['id' => 'currency'],
                'label' => 'Devise',
                'required' => true,
            ])
            ->add('typeForfait', EntityType::class, [
                'class' => TypeForfait::class,
                'choice_label' => 'titre',
                'disabled' => false,
                'mapped' => false,
                'required' => true,
                'label' => 'Choisir un type Forfait',

            ])

        ;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => PrixForfaitConfig::class,
		]);
	}
}
