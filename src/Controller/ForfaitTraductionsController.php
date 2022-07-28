<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\ForfaitTraductions;
use App\Form\ForfaitTraductionsType;
use App\Repository\ForfaitTraductionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forfait/traductions')]
class ForfaitTraductionsController extends AbstractController
{
	#[Route('/', name: 'app_forfait_traductions_index', methods: ['GET'])]
	public function index(ForfaitTraductionsRepository $forfaitTraductionsRepository): Response
	{
		return $this->render('forfait_traductions/index.html.twig', [
			'forfait_traductions' => $forfaitTraductionsRepository->findAll(),
		]);
	}

	#[Route('/new', name: 'app_forfait_traductions_new', methods: ['GET', 'POST'])]
	public function new(Request $request, ForfaitTraductionsRepository $forfaitTraductionsRepository): Response
	{
		$forfaitTraduction = new ForfaitTraductions();
		$form = $this->createForm(ForfaitTraductionsType::class, $forfaitTraduction);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitTraductionsRepository->add($forfaitTraduction, true);

			return $this->redirectToRoute('app_forfait_traductions_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait_traductions/new.html.twig', [
			'forfait_traduction' => $forfaitTraduction,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_traductions_show', methods: ['GET'])]
	public function show(ForfaitTraductions $forfaitTraduction): Response
	{
		return $this->render('forfait_traductions/show.html.twig', [
			'forfait_traduction' => $forfaitTraduction,
		]);
	}

	#[Route('/{id}/edit', name: 'app_forfait_traductions_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, ForfaitTraductions $forfaitTraduction, ForfaitTraductionsRepository $forfaitTraductionsRepository): Response
	{
		$form = $this->createForm(ForfaitTraductionsType::class, $forfaitTraduction);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitTraductionsRepository->add($forfaitTraduction, true);

			return $this->redirectToRoute('app_forfait_traductions_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait_traductions/edit.html.twig', [
			'forfait_traduction' => $forfaitTraduction,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_traductions_delete', methods: ['POST'])]
	public function delete(Request $request, ForfaitTraductions $forfaitTraduction, ForfaitTraductionsRepository $forfaitTraductionsRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $forfaitTraduction->getId(), $request->request->get('_token'))) {
			$forfaitTraductionsRepository->remove($forfaitTraduction, true);
		}

		return $this->redirectToRoute('app_forfait_traductions_index', [], Response::HTTP_SEE_OTHER);
	}
}
