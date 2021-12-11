<?php

namespace App\Controller\Panel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
    #[Route('/panel/trip', name: 'app_panel_trip')]
    public function index(): Response
    {
        return $this->render('panel/trip/index.html.twig', [
            'controller_name' => 'TripController',
        ]);
    }
}
