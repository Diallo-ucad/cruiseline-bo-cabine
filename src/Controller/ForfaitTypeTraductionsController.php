<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\ForfaitTypeTraductions;
use App\Form\ForfaitTypeTraductionsType;
use App\Repository\ForfaitTypeTraductionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forfait/type/traductions')]
class ForfaitTypeTraductionsController extends AbstractController
{
	#[Route('/', name: 'app_forfait_type_traductions_index', methods: ['GET'])]
	public function index(ForfaitTypeTraductionsRepository $forfaitTypeTraductionsRepository): Response
	{
		return $this->render('forfait_type_traductions/index.html.twig', [
			'forfait_type_traductions' => $forfaitTypeTraductionsRepository->findAll(),
		]);
	}

	#[Route('/new', name: 'app_forfait_type_traductions_new', methods: ['GET', 'POST'])]
	public function new(Request $request, ForfaitTypeTraductionsRepository $forfaitTypeTraductionsRepository): Response
	{
		$forfaitTypeTraduction = new ForfaitTypeTraductions();
		$form = $this->createForm(ForfaitTypeTraductionsType::class, $forfaitTypeTraduction);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitTypeTraductionsRepository->add($forfaitTypeTraduction, true);

			return $this->redirectToRoute('app_forfait_type_traductions_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait_type_traductions/new.html.twig', [
			'forfait_type_traduction' => $forfaitTypeTraduction,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_type_traductions_show', methods: ['GET'])]
	public function show(ForfaitTypeTraductions $forfaitTypeTraduction): Response
	{
		return $this->render('forfait_type_traductions/show.html.twig', [
			'forfait_type_traduction' => $forfaitTypeTraduction,
		]);
	}

	#[Route('/{id}/edit', name: 'app_forfait_type_traductions_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, ForfaitTypeTraductions $forfaitTypeTraduction, ForfaitTypeTraductionsRepository $forfaitTypeTraductionsRepository): Response
	{
		$form = $this->createForm(ForfaitTypeTraductionsType::class, $forfaitTypeTraduction);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitTypeTraductionsRepository->add($forfaitTypeTraduction, true);

			return $this->redirectToRoute('app_forfait_type_traductions_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait_type_traductions/edit.html.twig', [
			'forfait_type_traduction' => $forfaitTypeTraduction,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_type_traductions_delete', methods: ['POST'])]
	public function delete(Request $request, ForfaitTypeTraductions $forfaitTypeTraduction, ForfaitTypeTraductionsRepository $forfaitTypeTraductionsRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $forfaitTypeTraduction->getId(), $request->request->get('_token'))) {
			$forfaitTypeTraductionsRepository->remove($forfaitTypeTraduction, true);
		}

		return $this->redirectToRoute('app_forfait_type_traductions_index', [], Response::HTTP_SEE_OTHER);
	}
}
