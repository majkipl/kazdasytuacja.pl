<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Gender;
use App\Entity\Shop;
use App\Entity\Trip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class TripFormType extends AbstractType
{
    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $genders = $this->manager->getRepository(Gender::class)->findToSelectHtml();
        $shops = $this->manager->getRepository(Shop::class)->findToSelectHtml();
        $categories = $this->manager->getRepository(Category::class)->findToSelectHtml();

        $builder
            ->add('firstname', TextType::class, $this->getOptionsName())
            ->add('lastname', TextType::class, $this->getOptionsName())
            ->add('email', EmailType::class, $this->getOptionsEmail())
            ->add('street', TextType::class, $this->getOptionsAddress())
            ->add('city', TextType::class, $this->getOptionsAddress())
            ->add('code', TextType::class, $this->getOptionsCode())
            ->add('where', TextType::class, $this->getOptionsField())
            ->add('paragon', TextType::class, $this->getOptionsField())
            ->add('_paragon', TextType::class, $this->getOptionsParagonRepeat())
            ->add('product', TextType::class, $this->getOptionsField())
            ->add('try', TextareaType::class, $this->getOptionsTry())
            ->add('birth', TextType::class, $this->getOptionsBirth())
            ->add('sex', ChoiceType::class, $this->getOptionsChoice($genders))
            ->add('shop', ChoiceType::class, $this->getOptionsChoice($shops))
            ->add('category', ChoiceType::class, $this->getOptionsChoice($categories))
            ->add('legal_a', CheckboxType::class, [
                'label' => 'Akceptuję regulamin.',
                'required' => true,
                'constraints' => $this->getConstrintsLegal()
            ])
            ->add('legal_b', CheckboxType::class, [
                'label' => 'Wyrażam zgodę na przetwarzanie danych osobowych przez Loyal Concept Sp. z o.o. ul. Tużycka 8 lok. 6, 03-683 Warszawa, a także Highlite PR z siedzibą we Wrocławiu przy ul. Pomorskiej 55/2, 50-217 Wrocław wyłącznie w celu przeprowadzenia niniejszej Promocji, jej realizacji i wydania nagród. Administratorem danych osobowych jest SPECTRUM BRANDS POLAND sp. z o.o. z siedzibą w Warszawie, ul. Bitwy Warszawskiej 1920 r. 7a. Dane osobowe będą przetwarzane zgodnie z ustawą z dn. 29.08.1997 r. o ochronie danych osobowych (tekst jedn. Dz.U. z 2002, Nr 101, poz. 926 z późn. zm.). Podanie danych jest dobrowolne, lecz niezbędne dla potrzeb przeprowadzenia Promocji i wydania nagród.',
                'required' => true,
                'constraints' => $this->getConstrintsLegal()
            ])
            ->add('legal_c', CheckboxType::class, [
                'label' => 'Wyrażam zgodę na przetwarzanie danych osobowych przez SPECTRUM BRANDS POLAND sp. z o.o. z siedzibą w Warszawie, ul. Bitwy Warszawskiej 1920 r. 7a, a także Highlite PR z siedzibą we Wrocławiu przy ul. Pomorskiej 55/2, 50-217 Wrocław, w celach marketingowych zgodnie z ustawą z dn. 29.08.1997 r. o ochronie danych osobowych (tekst jedn. Dz.U. z 2002, Nr 101, poz. 926 z późn. zm.). Podanie danych jest dobrowolne. Uczestnikom Promocji przysługuje prawo dostępu do treści swoich danych oraz ich poprawiania.',
                'required' => true,
                'constraints' => $this->getConstrintsLegal()
            ]);
    }

    /**
     * @param $value
     * @param ExecutionContextInterface $context
     * @return void
     */
    public function validateEmailUnique($value, ExecutionContextInterface $context)
    {
        $row = $this->manager->getRepository(Trip::class)->findOneBy(['email' => $value]);

        if ($row !== null) {
            $context->buildViolation('Ten adres email został już wykorzystany.')
                ->atPath('email')
                ->addViolation();
        }
    }

    /**
     * @param $value
     * @param ExecutionContextInterface $context
     * @return void
     */
    public function validateParagonsMatch($value, ExecutionContextInterface $context): void
    {
        $formData = $context->getRoot()->getData();
        $paragonValue = $formData['paragon'] ?? null;

        if ($paragonValue !== $value) {
            $context
                ->buildViolation('Pola "paragon" i "_paragon" muszą mieć taką samą wartość.')
                ->atPath('_paragon')
                ->addViolation();
        }
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true
        ]);
    }

    /**
     * @return NotBlank
     */
    public function getNotBlank(): NotBlank
    {
        return new NotBlank([
            'message' => 'Pole nie może być puste.'
        ]);
    }

    /**
     * @return Length
     */
    public function getLengthBetween(): Length
    {
        return new Length([
            'min' => 3,
            'max' => 128,
            'minMessage' => 'Pole musi zawierać co najmniej {{ limit }} znaki.',
            'maxMessage' => 'Pole może zawierać maksymalnie {{ limit }} znaków.',
        ]);
    }

    /**
     * @return Length
     */
    public function getLengthMax(int $max): Length
    {
        return new Length([
            'max' => $max,
            'maxMessage' => 'Pole może zawierać maksymalnie {{ limit }} znaków.',
        ]);
    }

    /**
     * @param $genders
     * @return Choice
     */
    public function getChoice($genders): Choice
    {
        return new Choice([
            'choices' => array_flip($genders),
            'message' => 'Nieprawidłowy wybór.',
        ]);
    }

    /**
     * @param $arr
     * @return array
     */
    public function getConstraintsChoice($arr): array
    {
        return [
            $this->getNotBlank(),
            $this->getChoice($arr),
        ];
    }

    /**
     * @return IsTrue[]
     */
    public function getConstrintsLegal(): array
    {
        return [
            new IsTrue([
                'message' => 'Musisz zaakceptować warunek.',
            ]),
        ];
    }

    /**
     * @param $arr
     * @return array
     */
    public function getOptionsChoice($arr): array
    {
        return [
            'choices' => array_flip($arr),
            'placeholder' => '--- wybierz ---',
            'constraints' => $this->getConstraintsChoice($arr)
        ];
    }

    /**
     * @return array[]
     */
    public function getOptionsName(): array
    {
        return [
            'constraints' => [
                $this->getNotBlank(),
                $this->getLengthBetween(),
                new Regex([
                    'pattern' => '/^[a-zA-Z\s\-]+$/',
                    'message' => 'Pole powinno zawierać tylko litery, spację lub znak "-"',
                ]),
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getOptionsEmail(): array
    {
        return [
            'constraints' => [
                $this->getNotBlank(),
                $this->getLengthMax(255),
                new Email([
                    'message' => 'Wpisz poprawny adres email.'
                ]),
                new Callback([
                    'callback' => [$this, 'validateEmailUnique'],
                ])
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getOptionsAddress(): array
    {
        return [
            'constraints' => [
                $this->getNotBlank(),
                $this->getLengthMax(128),
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getOptionsField(): array
    {
        return [
            'constraints' => [
                $this->getNotBlank(),
                $this->getLengthMax(),
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getOptionsTry(): array
    {
        return [
            'constraints' => [
                $this->getNotBlank(),
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getOptionsBirth(): array
    {
        return [
            'constraints' => [
                $this->getNotBlank(),
                new Regex([
                    'pattern' => '/^\d{2}-\d{2}-\d{4}$/',
                    'message' => 'Nieprawidłowy format daty. Poprawny format to DD-MM-RRRR.',
                ]),
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getOptionsParagonRepeat(): array
    {
        return [
            'constraints' => [
                $this->getNotBlank(),
                $this->getLengthMax(),
                new Callback([$this, 'validateParagonsMatch']),
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getOptionsCode(): array
    {
        return [
            'constraints' => [
                $this->getNotBlank(),
                new Regex([
                    'pattern' => '/^\d{2}-\d{3}$/',
                    'message' => 'Kod pocztowy powinien być w formacie xx-xxx.',
                ]),
            ]
        ];
    }
}
