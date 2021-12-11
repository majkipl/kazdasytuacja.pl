<?php

namespace App\Factory;

use App\Entity\Gender;
use App\Repository\GenderRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Gender>
 *
 * @method        Gender|Proxy create(array|callable $attributes = [])
 * @method static Gender|Proxy createOne(array $attributes = [])
 * @method static Gender|Proxy find(object|array|mixed $criteria)
 * @method static Gender|Proxy findOrCreate(array $attributes)
 * @method static Gender|Proxy first(string $sortedField = 'id')
 * @method static Gender|Proxy last(string $sortedField = 'id')
 * @method static Gender|Proxy random(array $attributes = [])
 * @method static Gender|Proxy randomOrCreate(array $attributes = [])
 * @method static GenderRepository|RepositoryProxy repository()
 * @method static Gender[]|Proxy[] all()
 * @method static Gender[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Gender[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Gender[]|Proxy[] findBy(array $attributes)
 * @method static Gender[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Gender[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class GenderFactory extends ModelFactory
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
            // ->afterInstantiate(function(Gender $gender): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Gender::class;
    }
}
