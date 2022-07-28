<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\ForfaitConfig;
use App\Form\ForfaitConfigType;
use App\Repository\CabinCategoryRepository;
use App\Repository\CabinTypeRepository;
use App\Repository\ForfaitConfigRepository;
use App\Repository\PrixForfaitConfigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forfait/config')]
class ForfaitConfigController extends AbstractController
{
	#[Route('/', name: 'app_forfait_config_index', methods: ['GET'])]
	public function index(ForfaitConfigRepository $forfaitConfigRepository): Response
	{
		return $this->render('forfait_config/index.html.twig', [
			'forfait_configs' => $forfaitConfigRepository->findAll(),
		]);
	}

	#[Route('/new', name: 'app_forfait_config_new', methods: ['GET', 'POST'])]
	public function new(Request $request, ForfaitConfigRepository $forfaitConfigRepository, CabinCategoryRepository $cabinCategoryRepository, CabinTypeRepository $cabinTypeRepository, PrixForfaitConfigRepository $prixForfaitConfigRepository): Response
	{
		$forfaitConfig = new ForfaitConfig();
		if ($request->get('companyId')) {
			$companyId = (int) $request->get('companyId');
			$bateauId = (int) $request->get('bateauId');
			$portId = (int) $request->get('portId');
			$cabinCategoryId = (int) $request->get('cabinCategory');
			$cabinCategory = $cabinCategoryRepository->find($cabinCategoryId);
			$cabinTypeId = (int) $request->get('cabinTypes');
			$cabinType = $cabinTypeRepository->find($cabinTypeId);

			$forfaitConfig->
            setBateauId($bateauId)
                ->setPortId($portId)
                ->setCompanyId($companyId)
                ->setCabinCategory($cabinCategory)
                ->setCabinType($cabinType);
			$forfaitConfigRepository->add($forfaitConfig, true);

			return $this->redirectToRoute('app_forfait_config_index', [], Response::HTTP_SEE_OTHER);
		}

		$form = $this->createForm(ForfaitConfigType::class, $forfaitConfig);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitConfigRepository->add($forfaitConfig, true);

			return $this->redirectToRoute('app_forfait_config_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait_config/new.html.twig', [
			'forfait_config' => $forfaitConfig,
            'prix_forfait_configs' => $prixForfaitConfigRepository->findAll(),
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_config_show', methods: ['GET'])]
	public function show(ForfaitConfig $forfaitConfig): Response
	{
		return $this->render('forfait_config/show.html.twig', [
			'forfait_config' => $forfaitConfig,
		]);
	}

	#[Route('/{id}/edit', name: 'app_forfait_config_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, ForfaitConfig $forfaitConfig, ForfaitConfigRepository $forfaitConfigRepository): Response
	{
		$form = $this->createForm(ForfaitConfigType::class, $forfaitConfig);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$forfaitConfigRepository->add($forfaitConfig, true);

			return $this->redirectToRoute('app_forfait_config_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('forfait_config/edit.html.twig', [
			'forfait_config' => $forfaitConfig,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_forfait_config_delete', methods: ['POST'])]
	public function delete(Request $request, ForfaitConfig $forfaitConfig, ForfaitConfigRepository $forfaitConfigRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $forfaitConfig->getId(), $request->request->get('_token'))) {
			$forfaitConfigRepository->remove($forfaitConfig, true);
		}

		return $this->redirectToRoute('app_forfait_config_index', [], Response::HTTP_SEE_OTHER);
	}
}
