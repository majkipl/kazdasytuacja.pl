<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Gender;
use App\Entity\Shop;
use App\Entity\Trip;
use App\Form\TripFormType;
use App\Service\TripFormMailer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class TripFormController extends AbstractController
{
    public function __construct(
        private TripFormMailer $mailer,
        private RouterInterface $router,
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('/wygraj-wyjazd', name: 'app_trip_form')]
    public function index(Request $request): Response
    {
        $form= $this->createForm(TripFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $formData = $form->getData();

                $birth = DateTimeImmutable::createFromFormat('d-m-Y', $formData['birth']);
                $gender = $this->entityManager->getRepository(Gender::class)->find($formData['sex']);
                $shop = $this->entityManager->getRepository(Shop::class)->find($formData['shop']);
                $category = $this->entityManager->getRepository(Category::class)->find($formData['category']);

                $trip = new Trip();
                $trip->setFirstname($formData['firstname']);
                $trip->setLastname($formData['lastname']);
                $trip->setEmail($formData['email']);
                $trip->setStreet($formData['street']);
                $trip->setCity($formData['city']);
                $trip->setCode($formData['code']);
                $trip->setFromWhere($formData['where']);
                $trip->setReceipt($formData['paragon']);
                $trip->setProduct($formData['product']);
                $trip->setTry($formData['try']);
                $trip->setBirth($birth);
                $trip->setGender($gender);
                $trip->setShop($shop);
                $trip->setCategory($category);
                $trip->setLegalA($formData['legal_a']);
                $trip->setLegalB($formData['legal_b']);
                $trip->setLegalC($formData['legal_c']);

                $this->entityManager->persist($trip);
                $this->entityManager->flush();

                $this->mailer->sendEmail($formData);

                $url = $this->router->generate('app_tripform_thx');

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

        return $this->render('trip_form/index.html.twig', [
            'controller_name' => 'TripFormController',
            'form' => $form->createView(),
            'genders' => [],
            'shops' => [],
            'categories' => []
        ]);
    }

    #[Route('/wygraj-wyjazd/podziekowania', name: 'app_tripform_thx')]
    public function thx()
    {
        return $this->render('trip_form/thx.html.twig');
    }
}
