<?php

namespace App\Controller;

use App\Entity\Flashlight;
use App\Form\ContactFormType;
use App\Repository\FlashlightRepository;
use App\Repository\TripRepository;
use App\Service\ContactFormMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class DefaultController extends AbstractController
{
    public function __construct(
        private ContactFormMailer $contactFormMailer,
        private RouterInterface $router,
        private EntityManagerInterface $manager
    ) {}

    #[Route('/', name: 'app_default')]
    public function index(Request $request, MailerInterface $mailer, TripRepository $repository): JsonResponse|Response
    {
        $trips = $repository->findBy([], ['id' => 'DESC'], 5);

        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $formData = $form->getData();

                $this->contactFormMailer->sendContactEmail($_ENV['MAIL_SENDER_EMAIL'], $formData);

                $url = $this->router->generate('app_contact');

                return new JsonResponse(['success' => true, 'redirect' => $url]);
            } else {
                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }

                return new JsonResponse(['success' => false, 'errors' => $errors]);
            }
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'players' => $trips,
            'rating' => $trips,
            'formContact' => $form->createView()
        ]);
    }
}
