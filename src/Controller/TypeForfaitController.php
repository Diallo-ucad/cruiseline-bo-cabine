<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\ForfaitContent;
use App\Entity\TypeForfait;
use App\Form\ForfaitContentType;
use App\Form\TypeForfaitType;
use App\Repository\ForfaitRepository;
use App\Repository\TypeForfaitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/forfait')]
class TypeForfaitController extends AbstractController
{
	#[Route('/', name: 'app_type_forfait_index', methods: ['GET', 'POST'])]
	public function index(Request $request, TypeForfaitRepository $typeForfaitRepository): Response
	{
		$forfaitContent = new ForfaitContent();
		$form = $this->createForm(ForfaitContentType::class, $forfaitContent);
		$form->handleRequest($request);
		return $this->render('type_forfait/index.html.twig', [
			'type_forfaits' => $typeForfaitRepository->findAll(),
			'form' => $form->createView(),
		]);
	}

	#[Route('/new', name: 'app_type_forfait_new', methods: ['GET', 'POST'])]
	public function new(Request $request, TypeForfaitRepository $typeForfaitRepository): Response
	{
		$typeForfait = new TypeForfait();
		$form = $this->createForm(TypeForfaitType::class, $typeForfait);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$typeForfaitRepository->add($typeForfait, true);

			return $this->redirectToRoute('app_type_forfait_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('type_forfait/new.html.twig', [
			'type_forfait' => $typeForfait,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_type_forfait_show', methods: ['GET'])]
	public function show(Request $request, TypeForfait $typeForfait, ForfaitRepository $forfaitRepository): Response
	{
		$id_type = $request->attributes->get('id');

		$forfaits = $forfaitRepository->findByTypeForfaitId($id_type);

		return $this->render('type_forfait/show.html.twig', [
			'type_forfait' => $typeForfait,
			'forfaits' => $forfaits,
		]);
	}

	#[Route('/{id}/edit', name: 'app_type_forfait_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, TypeForfait $typeForfait, TypeForfaitRepository $typeForfaitRepository): Response
	{
		$form = $this->createForm(TypeForfaitType::class, $typeForfait);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$typeForfaitRepository->add($typeForfait, true);

			return $this->redirectToRoute('app_type_forfait_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('type_forfait/edit.html.twig', [
			'type_forfait' => $typeForfait,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_type_forfait_delete', methods: ['POST'])]
	public function delete(Request $request, TypeForfait $typeForfait, TypeForfaitRepository $typeForfaitRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $typeForfait->getId(), $request->request->get('_token'))) {
			$typeForfaitRepository->remove($typeForfait, true);
		}

		return $this->redirectToRoute('app_type_forfait_index', [], Response::HTTP_SEE_OTHER);
	}
}
