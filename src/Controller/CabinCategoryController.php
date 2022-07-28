<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\CabinCategory;
use App\Form\CabinCategoryType;
use App\Repository\CabinCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cabin/category')]
class CabinCategoryController extends AbstractController
{
	#[Route('/', name: 'app_cabin_category_index', methods: ['GET'])]
	public function index(CabinCategoryRepository $cabinCategoryRepository): Response
	{
		return $this->render('cabin_category/index.html.twig', [
			'cabin_categories' => $cabinCategoryRepository->findAll(),

		]);
	}

	#[Route('/new', name: 'app_cabin_category_new', methods: ['GET', 'POST'])]
	public function new(Request $request, CabinCategoryRepository $cabinCategoryRepository): Response
	{
		$cabinCategory = new CabinCategory();
		$form = $this->createForm(CabinCategoryType::class, $cabinCategory);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$cabinCategoryRepository->add($cabinCategory);

			return $this->redirectToRoute('app_cabin_category_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('cabin_category/new.html.twig', [
			'cabin_category' => $cabinCategory,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_cabin_category_show', methods: ['GET'])]
	public function show(CabinCategory $cabinCategory, CabinCategoryRepository $cabinCategoryRepository): Response
	{
		return $this->render('cabin_category/show.html.twig', [
			'cabin_category' => $cabinCategory,
		]);
	}

	#[Route('/{id}/edit', name: 'app_cabin_category_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, CabinCategory $cabinCategory, CabinCategoryRepository $cabinCategoryRepository): Response
	{
		$form = $this->createForm(CabinCategoryType::class, $cabinCategory);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$cabinCategoryRepository->add($cabinCategory);
			//return $this->redirectToRoute('app_cabin_category_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('cabin_category/edit.html.twig', [
			'cabin_category' => $cabinCategory,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_cabin_category_delete', methods: ['POST'])]
	public function delete(Request $request, CabinCategory $cabinCategory, CabinCategoryRepository $cabinCategoryRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $cabinCategory->getId(), $request->request->get('_token'))) {
			$cabinCategoryRepository->remove($cabinCategory);
		}

		return $this->redirectToRoute('app_cabin_category_index', [], Response::HTTP_SEE_OTHER);
	}
}
