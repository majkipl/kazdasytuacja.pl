<?php

namespace App\Factory;

use App\Entity\Category;
use App\Entity\Gender;
use App\Entity\Shop;
use App\Entity\Trip;
use App\Repository\TripRepository;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Trip>
 *
 * @method        Trip|Proxy create(array|callable $attributes = [])
 * @method static Trip|Proxy createOne(array $attributes = [])
 * @method static Trip|Proxy find(object|array|mixed $criteria)
 * @method static Trip|Proxy findOrCreate(array $attributes)
 * @method static Trip|Proxy first(string $sortedField = 'id')
 * @method static Trip|Proxy last(string $sortedField = 'id')
 * @method static Trip|Proxy random(array $attributes = [])
 * @method static Trip|Proxy randomOrCreate(array $attributes = [])
 * @method static TripRepository|RepositoryProxy repository()
 * @method static Trip[]|Proxy[] all()
 * @method static Trip[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Trip[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Trip[]|Proxy[] findBy(array $attributes)
 * @method static Trip[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Trip[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class TripFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private EntityManagerInterface $manager)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $gender = $this->manager->getRepository(Gender::class)->find(self::faker()->numberBetween(1,2));
        $shop = $this->manager->getRepository(Shop::class)->find(self::faker()->numberBetween(1,15));
        $category = $this->manager->getRepository(Category::class)->find(self::faker()->numberBetween(1,3));

        return [
            'birth' => self::faker()->dateTime(),
            'category' => $category,
            'city' => self::faker()->city(),
            'code' => self::faker()->regexify('\d{2}-\d{3}'),
            'email' => self::faker()->email(),
            'firstname' => self::faker()->firstName(),
            'from_where' => self::faker()->text(255),
            'gender' => $gender,
            'lastname' => self::faker()->lastName(),
            'legal_a' => true,
            'legal_b' => true,
            'legal_c' => true,
            'product' => self::faker()->text(255),
            'receipt' => self::faker()->numberBetween(100000,999999),
            'shop' => $shop,
            'street' => self::faker()->text(128),
            'try' => self::faker()->text(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Trip $trip): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Trip::class;
    }
}
