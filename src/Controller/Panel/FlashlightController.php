<?php

namespace App\Controller\Panel;

use App\Entity\Flashlight;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlashlightController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager
    )
    {
        //
    }

    #[Route('/panel/flashlight', name: 'app_panel_flashlight')]
    public function index(): Response
    {
        $items = $this->manager->getRepository(Flashlight::class)->findAll();

        return $this->render('panel/flashlight/index.html.twig', [
            'controller_name' => 'FlashlightController',
            'items' => $items
        ]);
    }
}
