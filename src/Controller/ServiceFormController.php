<?php

declare(strict_types=1);
namespace App\Controller;

use App\Entity\Forfait;
use App\Entity\ForfaitConfig;
use App\Entity\ForfaitContent;
use App\Entity\PrixForfaitConfig;
use App\Entity\TypeForfait;
use App\Factory\JsonResponseFactory;
use App\Form\ForfaitContentType;
use App\Form\ForfaitType;
use App\Form\PrixForfaitConfigType;
use App\Form\TypeForfaitType;
use App\Repository\CabinCategoryRepository;
use App\Repository\CabinTypeRepository;
use App\Repository\ForfaitConfigRepository;
use App\Repository\ForfaitContentRepository;
use App\Repository\ForfaitRepository;
use App\Repository\PrixForfaitConfigRepository;
use App\Repository\TypeForfaitRepository;
use mysql_xdevapi\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/service/form')]
class ServiceFormController extends AbstractController
{
	/**
	 * @param  Request                 $request
	 * @param  CabinCategoryRepository $cabinCategoryRepository
	 * @param  CabinTypeRepository     $cabinTypeRepository
	 * @return Response
	 */
	#[Route('/refreshCategoryFieldData', name: 'app_service_form_refreshCategoryFieldsData', methods: ['GET'])]
	public function refreshCategoryFieldData(Request $request, CabinCategoryRepository $cabinCategoryRepository, CabinTypeRepository $cabinTypeRepository): Response
	{
		$requestData = $request->get('data');
		$companyId = $requestData['companyId'];
		$boatId = $requestData['boatId'];
        $lang = $requestData ['lang'];

		$cabinCategories = $cabinCategoryRepository->findByCompanyIdAndBoatId($companyId, $boatId, $lang);
		$cabinTypes = $cabinTypeRepository->findByCategoryId(3);

		$selectHtml = $this->render('forfait_config/selectCategory.html.twig', [
			'cabinCategories' => $cabinCategories,
			'cabinTypes' => $cabinTypes,
		]);

		$response = new Response();
		$response->setContent(json_encode([
			'categoriesList' => $selectHtml,
		]));
		$response->headers->set('Content-Type', 'application/json');

		return $selectHtml;
	}

	/**
	 * @param  Request             $request
	 * @param  CabinTypeRepository $cabinTypeRepository
	 * @return Response
	 */
	#[Route('/refreshTypeFieldData', name: 'app_service_form_refreshTypeFieldData', methods: ['GET'])]
	public function refreshTypeFieldData(Request $request, CabinTypeRepository $cabinTypeRepository): Response
	{
		$categoryCabinId = $request->get('data');
		$cabinTypes = $cabinTypeRepository->findByCategoryId($categoryCabinId);

		$selectHtml = $this->render('forfait_config/selectType.html.twig', [
			'cabinTypes' => $cabinTypes,
		]);

		$response = new Response();
		$response->setContent(json_encode([
			'selectHtml' => $selectHtml,
		]));
		$response->headers->set('Content-Type', 'application/json');

		return $selectHtml;
	}

	/**
	 * @param  Request                     $request
	 * @param  ForfaitConfigRepository     $forfaitConfigRepository
	 * @param  PrixForfaitConfigRepository $prixForfaitConfigRepository
	 * @param  ForfaitRepository           $forfaitRepository
	 * @return Response
	 */
	#[Route('/ConfiguredForfaits', name: 'app_service_form_ConfiguredForfaits', methods: ['GET'])]
	public function showConfiguredForfait(Request $request, ForfaitConfigRepository $forfaitConfigRepository, PrixForfaitConfigRepository $prixForfaitConfigRepository, ForfaitRepository $forfaitRepository): Response
	{
		$requestData = $request->get('data');
		//user data
		$portId = $requestData['portId'];
		$boatId = $requestData['boatId'];
		$companyId = $requestData['companyId'];
		$cabinCategoryId = $requestData['cabinCategoryId'];
		$cabinTypeId = $requestData['cabinTypeId'];
		//forfaitConfig corresponding on user data
		$forfaitConfig = $forfaitConfigRepository->findOneByAllFields($portId, $companyId, $boatId, $cabinCategoryId, $cabinTypeId);
		$forfaits = [];
		$isConfig = false;
		$result = null;
		//Check if that user config exist, then show forfait(s)
		if (0 != count($forfaitConfig)) {
			$isConfig = true;
			$forfaitConfigId = $forfaitConfig[0]->getId();
			//prixFofaitConfig corresponding on user data
			$prixForfaitConfigs = $prixForfaitConfigRepository->findByForfaitConfig($forfaitConfigId);
			foreach ($prixForfaitConfigs as $prixForfaitConfig) {
				$forfait = $forfaitRepository->find($prixForfaitConfig->getForfait()->getId());
				array_push($forfaits, $forfait);
			}
			$result = $this->render('forfait/index.html.twig', [
				'forfaits' => $forfaits,
			]);
		} else {
			$result = $this->render('forfait_config/newConfigForm.html.twig', [
				'Infos' => 'Configuration non trouvé!',
			]);
		}
		$response = new Response();
		$response->setContent(json_encode([
			'listForfait' => $result,

		]));
		$response->headers->set('Content-Type', 'application/json');

		return $result;
	}

	/**
	 * @param  Request                     $request
	 * @param  PrixForfaitConfigRepository $prixForfaitConfigRepository
	 * @param  CabinCategoryRepository     $cabinCategoryRepository
	 * @param  CabinTypeRepository         $cabinTypeRepository
	 * @param  ForfaitConfigRepository     $forfaitConfigRepository
	 * @return Response
	 */
	#[Route('/newForfaitConfig', name: 'app_service_form_newForfaitConfig', methods: ['GET', 'POST'])]
	public function newForfaitConfig(Request $request, PrixForfaitConfigRepository $prixForfaitConfigRepository, CabinCategoryRepository $cabinCategoryRepository, CabinTypeRepository $cabinTypeRepository, ForfaitConfigRepository $forfaitConfigRepository, ForfaitRepository $forfaitRepository): Response
	{
		//user data
		$requestData = $request->get('data');
		$portId = (int) $requestData['portId'];
		$companyId = (int) $requestData['companyId'];
		$boatId = (int) $requestData['boatId'];
		$cabinCategoryId = (int) $requestData['cabinCategoryId'];
		$cabinCategory = $cabinCategoryRepository->find($cabinCategoryId);
		$cabinTypeId = (int) $requestData['cabinTypeId'];
		$cabinType = $cabinTypeRepository->find($cabinTypeId);
		//create and set forfait config object attributes
		$forfaitConfig = new ForfaitConfig();
		$forfaitConfig->
            setBateauId($boatId)
                ->setPortId($portId)
                ->setCompanyId($companyId)
                ->setCabinCategory($cabinCategory)
                ->setCabinType($cabinType);

		$forfaitConfigRepository->add($forfaitConfig, true);

		$forfaits = $forfaitRepository->findByCompanyId($companyId);
		$prixForfaitConfig = new PrixForfaitConfig();
		$form = $this->createForm(PrixForfaitConfigType::class, $prixForfaitConfig, ['attr' => [$forfaitConfig]]);
		$form->handleRequest($request);
		$result = $this->renderForm('prix_forfait_config/new.html.twig', [
			'prix_forfait_config' => $prixForfaitConfig,
			'form' => $form,
		]);

		return  $result;
	}



    /**
     * @param  Request                     $request
     * @param  PrixForfaitConfigRepository $prixForfaitConfigRepository
     * @param  CabinCategoryRepository     $cabinCategoryRepository
     * @param  CabinTypeRepository         $cabinTypeRepository
     * @param  ForfaitConfigRepository     $forfaitConfigRepository
     * @return Response
     */
    #[Route('/addAllForfaitConfig', name: 'app_service_form_addAllForfaitConfig', methods: ['GET', 'POST'])]
    public function addAllForfaitConfig(Request $request, PrixForfaitConfigRepository $prixForfaitConfigRepository, CabinCategoryRepository $cabinCategoryRepository, CabinTypeRepository $cabinTypeRepository, ForfaitConfigRepository $forfaitConfigRepository, ForfaitRepository $forfaitRepository, JsonResponseFactory $jsonResponseFactory): Response
    {
        //user data
        $requestData = $request->get('data');
        $portId = (int) $requestData['portId'];
        $companyId = (int) $requestData['companyId'];
        $boatId = (int) $requestData['boatId'];
        $lang = $requestData['lang'];

        $cabinCategories = $cabinCategoryRepository->findByCompanyIdAndBoatId($companyId, $boatId,$lang );
        $forfaitConfig = new ForfaitConfig();
        $insertedForfaitConfigsId = [];
        foreach ($cabinCategories as $cabinCategory ){
            $cabinCategoryId = (int) $cabinCategory->getId();
            $cabinTypes = $cabinTypeRepository->findByCategoryId($cabinCategoryId);
            foreach ($cabinTypes as $cabinType){
                $forfaitConfig = new ForfaitConfig();
                $forfaitConfig->
                setBateauId($boatId)
                    ->setPortId($portId)
                    ->setCompanyId($companyId)
                    ->setCabinCategory($cabinCategory)
                    ->setCabinType($cabinType);
                $insertedId = $forfaitConfigRepository->addAll($forfaitConfig, true);
                array_push($insertedForfaitConfigsId, $insertedId);
            }
        }
        //$cabinTypeId = (int) $requestData['cabinTypeId'];
        //$cabinType = $cabinTypeRepository->find($cabinTypeId);
        //create and set forfait config object attributes
        $forfaits = $forfaitRepository->findByCompanyId($companyId);
        $prixForfaitConfig = new PrixForfaitConfig();
        $form = $this->createForm(PrixForfaitConfigType::class, $prixForfaitConfig, ['attr' => [$forfaitConfig]]);
        $form->handleRequest($request);
        $result = $this->renderForm('prix_forfait_config/new.html.twig', [
            'prix_forfait_config' => $prixForfaitConfig,
            'form' => $form,
        ]);

        $response = [
            'html' => $result,
            'forfaitsConfigsIds' => $insertedForfaitConfigsId,
        ];
        return  $jsonResponseFactory->create((object)($response));
    }

	#[Route('/addForfaitToConfig', name: 'app_service_form_addForfaitToConfig', methods: ['GET', 'POST'])]
	public function addForfaitToConfig(Request $request, PrixForfaitConfigRepository $prixForfaitConfigRepository, CabinCategoryRepository $cabinCategoryRepository, CabinTypeRepository $cabinTypeRepository, ForfaitConfigRepository $forfaitConfigRepository, ForfaitRepository $forfaitRepository): Response
	{
		//user data
		$requestData = $request->get('data');
		$portId = (int) $requestData['portId'];
		$companyId = (int) $requestData['companyId'];
		$boatId = (int) $requestData['boatId'];
		$cabinCategoryId = (int) $requestData['cabinCategoryId'];
		$cabinCategory = $cabinCategoryRepository->find($cabinCategoryId);
		$cabinTypeId = (int) $requestData['cabinTypeId'];
		$cabinType = $cabinTypeRepository->find($cabinTypeId);
		//create and set forfait config object attributes
		$forfaitConfig = $forfaitConfigRepository->findOneByAllFields($portId, $companyId, $boatId, $cabinCategoryId, $cabinTypeId)[0];
		$forfaits = $forfaitRepository->findByCompanyId($companyId);
		$formParams = ['forfaitConfig' => $forfaitConfig, 'forfaits' => $forfaits];
		$prixForfaitConfig = new PrixForfaitConfig();
		$form = $this->createForm(PrixForfaitConfigType::class, $prixForfaitConfig, ['attr' => [$forfaitConfig]]);
		$form->handleRequest($request);
		$result = $this->renderForm('prix_forfait_config/_form.html.twig', [
			'prix_forfait_config' => $prixForfaitConfig,
			'form' => $form,
		]);

		return  $result;
	}

	/**
	 * @param  Request                               $request
	 * @param  ForfaitConfigRepository               $forfaitConfigRepository
	 * @param  ForfaitRepository                     $forfaitRepository
	 * @param  PrixForfaitConfigRepository           $prixForfaitConfigRepository
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 * @return Response
	 */
	#[Route('/newPrixForfaitConfig', name: 'app_service_form_newPrixForfaitConfig', methods: ['GET', 'POST'])]
	public function newPrixForfaitConfig(Request $request, ForfaitConfigRepository $forfaitConfigRepository, ForfaitRepository $forfaitRepository, PrixForfaitConfigRepository $prixForfaitConfigRepository): Response
	{
		//user data
		$requestData = $request->get('data');
		$tarifSemaine = (int) $requestData['tarifSemaine'];
		$tarifJour = (int) $requestData['tarifJour'];
		$curency = $requestData['curency'];
		$isActif = (bool) $requestData['isActif'];
		$forfaitConfigId = (int) $requestData['forfaitConfig'];
		$forfaitConfig = $forfaitConfigRepository->find($forfaitConfigId);
		$forfaitId = (int) $requestData['forfait'];
		$forfait = $forfaitRepository->find($forfaitId);
		//create and set prix forfait config object attributes
		$prixForfaitConfig = new PrixForfaitConfig();
		$prixForfaitConfig->
        setTarifSemaine($tarifSemaine)
            ->setTarifJour($tarifJour)
            ->setCurrency($curency)
            ->setActif($isActif)
            ->setForfaitConfig($forfaitConfig)
            ->setForfait($forfait);

		//persist data on DB
		$prixForfaitConfigRepository->add($prixForfaitConfig, true);
		$result = $this->renderForm('forfait_config/index.html.twig', [
            'forfait_configs' => $forfaitConfigRepository->findAll()
		]);

		return  $result;
	}


    /**
     * @param  Request                               $request
     * @param  ForfaitConfigRepository               $forfaitConfigRepository
     * @param  ForfaitRepository                     $forfaitRepository
     * @param  PrixForfaitConfigRepository           $prixForfaitConfigRepository
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @return Response
     */
    #[Route('/addPrixForfaitConfigToAll', name: 'app_service_form_addPrixForfaitConfigToAll', methods: ['GET', 'POST'])]
    public function addPrixForfaitConfigToAll(Request $request, ForfaitConfigRepository $forfaitConfigRepository, ForfaitRepository $forfaitRepository, PrixForfaitConfigRepository $prixForfaitConfigRepository): Response
    {
        //user data
        $requestData = $request->get('data');
        $forfaitsConfigsIds = $requestData['ids'];
        $prixForfaitConfigData = $requestData['prixForfaitConfigData'];
        $tarifSemaine = (int) $prixForfaitConfigData['tarifSemaine'];
        $tarifJour = (int) $prixForfaitConfigData['tarifJour'];
        $curency = $prixForfaitConfigData['curency'];
        $isActif = (bool) $prixForfaitConfigData['isActif'];

        foreach ($forfaitsConfigsIds as $value){
            $forfaitConfigId = (int) ($value);
            $forfaitConfig = $forfaitConfigRepository->find($forfaitConfigId);
            $forfaitId = (int) $prixForfaitConfigData['forfait'];
            $forfait = $forfaitRepository->find($forfaitId);
            //create and set prix forfait config object attributes
            $prixForfaitConfig = new PrixForfaitConfig();
            $prixForfaitConfig->
            setTarifSemaine($tarifSemaine)
                ->setTarifJour($tarifJour)
                ->setCurrency($curency)
                ->setActif($isActif)
                ->setForfaitConfig($forfaitConfig)
                ->setForfait($forfait);
            //persist data on DB
            $prixForfaitConfigRepository->add($prixForfaitConfig, true);

        }

        $result = $this->renderForm('forfait_config/index.html.twig', [
            'forfait_configs' => $forfaitConfigRepository->findAll()
        ]);

        return  $result;
    }


    /**
	 * @param  Request               $request
	 * @param  ForfaitRepository     $forfaitRepository
	 * @param  TypeForfaitRepository $typeForfaitRepository
	 * @return Response
	 */
	#[Route('/refreshForfaitList', name: 'app_service_form_refreshForfaitList', methods: ['GET', 'POST'])]
	public function refreshForfaitList(Request $request, ForfaitRepository $forfaitRepository, TypeForfaitRepository $typeForfaitRepository): Response
	{
		//user data
		$requestData = $request->get('data');
		$typeForfaitId = (int) $requestData['typeForfaitId'];
		$typeForfait = $typeForfaitRepository->find($typeForfaitId);
		$companyId = (int) $requestData['companyId'];
		$forfaits = $forfaitRepository->findByCompanyIdAndForfaitType($typeForfait, $companyId);
		$selectHtml = $this->render('prix_forfait_config/selectForfait.html.twig', [
			'forfaits' => $forfaits,
		]);

		return $selectHtml;
	}

	#[Route('/newForfaitContentForm', name: 'app_service_form_newForfaitContentForm', methods: ['GET', 'POST'])]
	public function newForfaitContentForm(Request $request, ForfaitRepository $forfaitRepository): Response
	{
		//user data
		$forfaitId = (int) $request->get('data');

		$forfait = $forfaitRepository->find($forfaitId);
		$forfaitContent = new ForfaitContent();
		$form = $this->createForm(ForfaitContentType::class, $forfaitContent, ['attr' => [$forfait]]);
		$forfaitContent->setForfait($forfait);
		$form->handleRequest($request);

		return $this->renderForm('forfait_content/new.html.twig', [
			'forfait_content' => $forfaitContent,
			'selectedforfait' => $forfait,
			'form' => $form,
		]);
	}

	/**
	 * @param  Request                               $request
	 * @param  ForfaitConfigRepository               $forfaitConfigRepository
	 * @param  ForfaitRepository                     $forfaitRepository
	 * @param  PrixForfaitConfigRepository           $prixForfaitConfigRepository
	 * @throws \Doctrine\ORM\ORMException
	 * @throws \Doctrine\ORM\OptimisticLockException
	 * @return Response
	 */
	#[Route('/newForfaitContent', name: 'app_service_form_newForfaitContent', methods: ['GET', 'POST'])]
	public function newForfaitContent(Request $request, ForfaitRepository $forfaitRepository, ForfaitContentRepository $forfaitContentRepository): Response
	{
		//user data
		$requestData = $request->get('data');
		$forfaitId = (int) $requestData['forfaitId'];
		$forfait = $forfaitRepository->find($forfaitId);
		$lang = $requestData['lang'];
		$isMajor = (bool) $requestData['isMajor'];
		$position = (int) $requestData['position'];
		$description = $requestData['content'];
		//create and set prix forfait config object attributes
		$forfaitContent = new ForfaitContent();
		$forfaitContent->setForfait($forfait)
            ->setLangue($lang)
            ->setPosition($position)
            ->setAdultOnly($isMajor)
            ->setDescription($description);

		//persist data on DB
		$forfaitContentRepository->add($forfaitContent, true);
		$result = $this->renderForm('forfait_content/index.html.twig', [
            'forfait_contents' => $forfaitContentRepository->findAll()
        ]);

		return  $result;
	}

	/**
	 * @param  Request           $request
	 * @param  ForfaitRepository $forfaitRepository
	 * @return Response
	 */
	#[Route('/launchForfaitContentsModal', name: 'app_service_form_launchForfaitContentsModal', methods: ['GET', 'POST'])]
	public function launchForfaitContentsModal(Request $request, ForfaitRepository $forfaitRepository): Response
	{
		//user data
		$forfaitId = (int) $request->get('data');
		$forfait = $forfaitRepository->find($forfaitId);

		$fofaitContents = $forfait->getForfaitContents()->getValues();

		return $this->render('type_forfait/listForfaitContents.html.twig', [
			'forfait' => $forfait,
			'forfaitContents' => $fofaitContents,
		]);
	}

	/**
	 * @param  Request           $request
	 * @param  ForfaitRepository $forfaitRepository
	 * @return Response
	 */
	#[Route('/showForfaitContents', name: 'app_service_form_showForfaitContents', methods: ['GET', 'POST'])]
	public function showForfaitContents(Request $request, ForfaitRepository $forfaitRepository): Response
	{
		//user data
		$forfaitId = $request->get('data');
		$forfait = $forfaitRepository->find($forfaitId);
		$fofaitContents = $forfait->getForfaitContents()->getValues();

		return $this->render('forfait_content/index.html.twig', [
			'forfait_contents' => $fofaitContents,
			'forfait' => $forfait,
		]);
	}

    #[Route('/getNewForfaitModal', name: 'app_service_form_getNewForfaitModal', methods: ['GET', 'POST'])]
    public function getNewForfaitModal(Request $request, ForfaitRepository $forfaitRepository): Response
    {
        $task = $request->get('task');
        switch ($task){
            case 'forfait':
                $result = $this->render('forfait/newForfaitModal.html.twig', []);
            break;
            case 'typeForfait':
                $result = $this->render('type_forfait/newTypeForfaitModal.html.twig', []);
                break;
        }

        return $result;
    }

    #[Route('/getForfaitForm', name: 'app_service_form_getForfaitForm', methods: ['GET', 'POST'])]
    public function getForfaitForm(Request $request, ForfaitRepository $forfaitRepository, TypeForfaitRepository $typeForfaitRepository): Response
    {
        $typeForfaitId = $request->get('data');
        $typeForfait = $typeForfaitRepository->find($typeForfaitId);
        $forfait = new Forfait();
        $form = $this->createForm(ForfaitType::class, $forfait, ['attr' => [$typeForfait]]);
        $form->handleRequest($request);
        $forfait->setTypeForfait($typeForfait);
        return $this->renderForm('forfait/new.html.twig', [
            'forfait' => $forfait,
            'typeForfait' => $typeForfait,
            'form' => $form,
        ]);
    }

    #[Route('/getTypeForfaitForm', name: 'app_service_form_getTypeForfaitForm', methods: ['GET', 'POST'])]
    public function getTypeForfaitForm(Request $request, TypeForfaitRepository $typeForfaitRepository): Response
    {
        $typeForfait = new TypeForfait();
		$form = $this->createForm(TypeForfaitType::class, $typeForfait);
		$form->handleRequest($request);
        return $this->renderForm('type_forfait/new.html.twig', [
			'type_forfait' => $typeForfait,
			'form' => $form,
		]);
    }



    #[Route('/addNewForfait', name: 'app_service_form_addNewForfait', methods: ['GET', 'POST'])]
    public function addNewForfait(Request $request, ForfaitRepository $forfaitRepository, TypeForfaitRepository $typeForfaitRepository): Response
    {
        //user data
        $requestData = $request->get('data');
        $typeForfaitId = (int) $requestData['typeForfaitId'];
        $typeForfait = $typeForfaitRepository->find($typeForfaitId);
        $titre = $requestData['titre'];
        $companyId = (int) $requestData['companyId'];
        $isActif = (bool) $requestData['isActif'];

        //create and set forfait object attributes
        $forfait = new Forfait();
        $forfait->setTypeForfait($typeForfait)
            ->setForfaitTitre($titre)
            ->setActif($isActif)
            ->setCompanyId($companyId);
        //persist data on DB
        $forfaitRepository->add($forfait, true);

        return $this->render('forfait/index.html.twig', [
            'forfaits' => $forfaitRepository->findAll(),
        ]);
    }

    #[Route('/addNewTypeForfait', name: 'app_service_form_addNewTypeForfait', methods: ['GET', 'POST'])]
    public function addNewTypeForfait(Request $request, TypeForfaitRepository $typeForfaitRepository): Response
    {
        //user data
        $requestData = $request->get('data');
        $titre = $requestData['titre'];
        $isActif = (bool) $requestData['isActif'];
        $typeForfait = new TypeForfait();
        $typeForfait->setTitre($titre)
            ->setActif($isActif);
        //persist data on DB
        $typeForfaitRepository->add($typeForfait, true);

        $forfaitContent = new ForfaitContent();
        $form = $this->createForm(ForfaitContentType::class, $forfaitContent);
        $form->handleRequest($request);
        return $this->render('type_forfait/index.html.twig', [
            'type_forfaits' => $typeForfaitRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

}
