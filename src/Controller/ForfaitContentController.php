<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\ForfaitContent;
use App\Form\ForfaitContentType;
use App\Repository\ForfaitConfigRepository;
use App\Repository\ForfaitContentRepository;
use App\Repository\ForfaitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forfait/content')]
class ForfaitContentController extends AbstractController
{
	#[Route('/', name: 'app_forfait_content_index', methods: ['GET'])]
	public function index(ForfaitContentRepository $forfaitContentRepository): Response
	{
		return $this->render('forfait_content/index.html.twig', [
			'forfait_contents' => $forfaitContentRepository->findAll(),
		]);
	}

	#[Route('/new/{forfait_id}', name: 'app_forfait_content_new', methods: ['GET', 'POST'])]
	public function new(Request $request, ForfaitContentRepository $forfaitContentRepository, ForfaitRepository $forfaitRepository): Response
	{
		$forfait_id = $request->attributes->get('forfait_id');
		$forfait = $forfaitRepository->find($forfait_id);
		$forfaitContent = new ForfaitContent();
		$forfaitContent->setForfait($forfait);

		$form = $this->createForm(ForfaitContentType::class, $forfaitContent);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitContentRepository->add($forfaitContent, true);

			return $this->redirectToRoute('app_forfait_content_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait_content/new.html.twig', [
			'forfait_content' => $forfaitContent,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_content_show', methods: ['GET'])]
	public function show(Request $request, ForfaitContent $forfaitContent, ForfaitConfigRepository $forfaitConfigRepository): Response
	{
		return $this->render('forfait_content/show.html.twig', [
			'forfait_content' => $forfaitContent,

		]);
	}

	#[Route('/{id}/edit', name: 'app_forfait_content_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, ForfaitContent $forfaitContent, ForfaitContentRepository $forfaitContentRepository): Response
	{
		$form = $this->createForm(ForfaitContentType::class, $forfaitContent);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitContentRepository->add($forfaitContent, true);

			return $this->redirectToRoute('app_type_forfait_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait_content/edit.html.twig', [
			'forfait_content' => $forfaitContent,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_content_delete', methods: ['POST'])]
	public function delete(Request $request, ForfaitContent $forfaitContent, ForfaitContentRepository $forfaitContentRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $forfaitContent->getId(), $request->request->get('_token'))) {
			$forfaitContentRepository->remove($forfaitContent, true);
		}

		return $this->redirectToRoute('app_type_forfait_index', [], Response::HTTP_SEE_OTHER);
	}
}
