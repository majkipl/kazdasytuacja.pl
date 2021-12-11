<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Flashlight;
use App\Entity\Gender;
use App\Entity\Shop;
use App\Form\FlashlightFormType;
use App\Service\FlashlightFormMailer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class FlashlightFormController extends AbstractController
{

    public function __construct(
        private FlashlightFormMailer $mailer,
        private RouterInterface $router,
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('/odbierz-latarke', name: 'app_flashlight_form')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(FlashlightFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $formData = $form->getData();

                $birth = DateTimeImmutable::createFromFormat('d-m-Y', $formData['birth']);
                $gender = $this->entityManager->getRepository(Gender::class)->find($formData['sex']);
                $shop = $this->entityManager->getRepository(Shop::class)->find($formData['shop']);
                $category = $this->entityManager->getRepository(Category::class)->find($formData['category']);

                $flashlight = new Flashlight();
                $flashlight->setFirstname($formData['firstname']);
                $flashlight->setLastname($formData['lastname']);
                $flashlight->setEmail($formData['email']);
                $flashlight->setStreet($formData['street']);
                $flashlight->setCity($formData['city']);
                $flashlight->setCode($formData['code']);
                $flashlight->setFromWhere($formData['where']);
                $flashlight->setReceipt($formData['paragon']);
                $flashlight->setProduct($formData['product']);
                $flashlight->setBirth($birth);
                $flashlight->setGender($gender);
                $flashlight->setShop($shop);
                $flashlight->setCategory($category);
                $flashlight->setLegalA($formData['legal_a']);
                $flashlight->setLegalB($formData['legal_b']);
                $flashlight->setLegalC($formData['legal_c']);

                $this->entityManager->persist($flashlight);
                $this->entityManager->flush();

                $this->mailer->sendEmail($formData);

                $url = $this->router->generate('app_flashlightform_thx');

                return new JsonResponse(['success' => true, 'redirect' => $url]);
            } else {
                $errors = [];

                foreach ($form->getErrors(true) as $error) {
                    $field = $error->getOrigin()->getName();
                    $errors[$field] = $error->getMessage();
                }

                return new JsonResponse(['success' => false, 'errors' => $errors]);
            }
        }

        return $this->render('flashlight_form/index.html.twig', [
            'controller_name' => 'FlashlightFormController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/odbierz-latarke/podziekowania', name: 'app_flashlightform_thx')]
    public function thx()
    {
        return $this->render('flashlight_form/thx.html.twig');
    }
}
