<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncludesController extends AbstractController
{
    #[Route('/includes', name: 'app_includes')]
    public function index(): Response
    {
        return $this->render('includes/index.html.twig', [
            'controller_name' => 'IncludesController',
        ]);
    }
}
