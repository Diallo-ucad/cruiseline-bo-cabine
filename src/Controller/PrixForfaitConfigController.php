<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\PrixForfaitConfig;
use App\Form\PrixForfaitConfigType;
use App\Repository\PrixForfaitConfigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/prix/forfait/config')]
class PrixForfaitConfigController extends AbstractController
{
	#[Route('/', name: 'app_prix_forfait_config_index', methods: ['GET'])]
	public function index(PrixForfaitConfigRepository $prixForfaitConfigRepository): Response
	{
		return $this->render('prix_forfait_config/index.html.twig', [
			'prix_forfait_configs' => $prixForfaitConfigRepository->findAll(),
		]);
	}

	#[Route('/new', name: 'app_prix_forfait_config_new', methods: ['GET', 'POST'])]
	public function new(Request $request, PrixForfaitConfigRepository $prixForfaitConfigRepository): Response
	{
		$prixForfaitConfig = new PrixForfaitConfig();
		$form = $this->createForm(PrixForfaitConfigType::class, $prixForfaitConfig);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$prixForfaitConfigRepository->add($prixForfaitConfig);

			return $this->redirectToRoute('app_prix_forfait_config_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('prix_forfait_config/new.html.twig', [
			'prix_forfait_config' => $prixForfaitConfig,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_prix_forfait_config_show', methods: ['GET'])]
	public function show(PrixForfaitConfig $prixForfaitConfig): Response
	{
		return $this->render('prix_forfait_config/show.html.twig', [
			'prix_forfait_config' => $prixForfaitConfig,
		]);
	}

	#[Route('/{id}/edit', name: 'app_prix_forfait_config_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, PrixForfaitConfig $prixForfaitConfig, PrixForfaitConfigRepository $prixForfaitConfigRepository): Response
	{
		$form = $this->createForm(PrixForfaitConfigType::class, $prixForfaitConfig);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$prixForfaitConfigRepository->add($prixForfaitConfig);

			return $this->redirectToRoute('app_prix_forfait_config_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('prix_forfait_config/edit.html.twig', [
			'prix_forfait_config' => $prixForfaitConfig,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_prix_forfait_config_delete', methods: ['POST'])]
	public function delete(Request $request, PrixForfaitConfig $prixForfaitConfig, PrixForfaitConfigRepository $prixForfaitConfigRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $prixForfaitConfig->getId(), $request->request->get('_token'))) {
			$prixForfaitConfigRepository->remove($prixForfaitConfig);
		}

		return $this->redirectToRoute('app_prix_forfait_config_index', [], Response::HTTP_SEE_OTHER);
	}
}
