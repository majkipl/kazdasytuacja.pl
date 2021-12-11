<?php

namespace App\Controller\Panel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/panel', name: 'app_panel_dashboard')]
    public function index(): Response
    {
        return $this->render('panel/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
