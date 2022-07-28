<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\Forfait;
use App\Form\ForfaitType;
use App\Repository\ForfaitContentRepository;
use App\Repository\ForfaitRepository;
use App\Repository\TypeForfaitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forfait')]
class ForfaitController extends AbstractController
{
	#[Route('/', name: 'app_forfait_index', methods: ['GET'])]
	public function index(ForfaitRepository $forfaitRepository): Response
	{
		return $this->render('forfait/index.html.twig', [
			'forfaits' => $forfaitRepository->findAll(),
		]);
	}

	#[Route('/new/{id_type_forfait}', name: 'app_forfait_new', methods: ['GET', 'POST'])]
	public function new(Request $request, ForfaitRepository $forfaitRepository, TypeForfaitRepository $typeForfaitRepository): Response
	{
		$id_type = $request->attributes->get('id_type_forfait');
		$type_forfait = $typeForfaitRepository->find($id_type);

		$forfait = new Forfait();
		$form = $this->createForm(ForfaitType::class, $forfait, ['attr' => [$type_forfait]]);
		$form->handleRequest($request);
		$forfait->setTypeForfait($type_forfait);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitRepository->add($forfait, true);

			return $this->redirectToRoute('app_forfait_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait/new.html.twig', [
			'forfait' => $forfait,
			'typeForfait' => $type_forfait,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_show', methods: ['GET'])]
	public function show(Request $request, Forfait $forfait, ForfaitContentRepository $forfaitContentRepository): Response
	{
		$forfait_id = $request->attributes->get('id');
		$forfaitContents = $forfaitContentRepository->findByForfaitId($forfait_id);

		return $this->render('forfait/show.html.twig', [
			'forfait' => $forfait,
			'forfaitContents' => $forfaitContents,
		]);
	}

	#[Route('/{id}/edit', name: 'app_forfait_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, Forfait $forfait, ForfaitRepository $forfaitRepository, TypeForfaitRepository $typeForfaitRepository): Response
	{
		$typeForfaitId = $forfait->getTypeForfait()->getId();

		$typeForfait = $typeForfaitRepository->find($typeForfaitId);

		$form = $this->createForm(ForfaitType::class, $forfait, ['attr' => [$typeForfait]]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitRepository->add($forfait, true);

			return $this->redirectToRoute('app_type_forfait_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait/edit.html.twig', [
			'forfait' => $forfait,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_delete', methods: ['POST'])]
	public function delete(Request $request, Forfait $forfait, ForfaitRepository $forfaitRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $forfait->getId(), $request->request->get('_token'))) {
			$forfaitRepository->remove($forfait, true);
		}

		return $this->redirectToRoute('app_type_forfait_index', [], Response::HTTP_SEE_OTHER);
	}
}
