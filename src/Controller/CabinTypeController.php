<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\CabinType;
use App\Form\CabinTypeType;
use App\Repository\CabinTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cabin/type')]
class CabinTypeController extends AbstractController
{
	#[Route('/', name: 'app_cabin_type_index', methods: ['GET'])]
	public function index(CabinTypeRepository $cabinTypeRepository): Response
	{
		return $this->render('cabin_type/index.html.twig', [
			'cabin_types' => $cabinTypeRepository->findAll(),
		]);
	}

	#[Route('/new', name: 'app_cabin_type_new', methods: ['GET', 'POST'])]
	public function new(Request $request, CabinTypeRepository $cabinTypeRepository): Response
	{
		$cabinType = new CabinType();
		$form = $this->createForm(CabinTypeType::class, $cabinType);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$cabinTypeRepository->add($cabinType);

			return $this->redirectToRoute('app_cabin_type_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('cabin_type/new.html.twig', [
			'cabin_type' => $cabinType,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_cabin_type_show', methods: ['GET'])]
	public function show(CabinType $cabinType): Response
	{
		return $this->render('cabin_type/show.html.twig', [
			'cabin_type' => $cabinType,
		]);
	}

	#[Route('/{id}/edit', name: 'app_cabin_type_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, CabinType $cabinType, CabinTypeRepository $cabinTypeRepository): Response
	{
		$form = $this->createForm(CabinTypeType::class, $cabinType);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$cabinTypeRepository->add($cabinType);

			return $this->redirectToRoute('app_cabin_type_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('cabin_type/edit.html.twig', [
			'cabin_type' => $cabinType,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_cabin_type_delete', methods: ['POST'])]
	public function delete(Request $request, CabinType $cabinType, CabinTypeRepository $cabinTypeRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $cabinType->getId(), $request->request->get('_token'))) {
			$cabinTypeRepository->remove($cabinType);
		}

		return $this->redirectToRoute('app_cabin_type_index', [], Response::HTTP_SEE_OTHER);
	}
}
