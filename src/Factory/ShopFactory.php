<?php

namespace App\Factory;

use App\Entity\Shop;
use App\Repository\ShopRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Shop>
 *
 * @method        Shop|Proxy create(array|callable $attributes = [])
 * @method static Shop|Proxy createOne(array $attributes = [])
 * @method static Shop|Proxy find(object|array|mixed $criteria)
 * @method static Shop|Proxy findOrCreate(array $attributes)
 * @method static Shop|Proxy first(string $sortedField = 'id')
 * @method static Shop|Proxy last(string $sortedField = 'id')
 * @method static Shop|Proxy random(array $attributes = [])
 * @method static Shop|Proxy randomOrCreate(array $attributes = [])
 * @method static ShopRepository|RepositoryProxy repository()
 * @method static Shop[]|Proxy[] all()
 * @method static Shop[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Shop[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Shop[]|Proxy[] findBy(array $attributes)
 * @method static Shop[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Shop[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ShopFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
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
        return [
            'name' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Shop $shop): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Shop::class;
    }
}
