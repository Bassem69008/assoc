<?php

namespace App\Factory;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Family>
 *
 * @method        Family|Proxy                     create(array|callable $attributes = [])
 * @method static Family|Proxy                     createOne(array $attributes = [])
 * @method static Family|Proxy                     find(object|array|mixed $criteria)
 * @method static Family|Proxy                     findOrCreate(array $attributes)
 * @method static Family|Proxy                     first(string $sortedField = 'id')
 * @method static Family|Proxy                     last(string $sortedField = 'id')
 * @method static Family|Proxy                     random(array $attributes = [])
 * @method static Family|Proxy                     randomOrCreate(array $attributes = [])
 * @method static FamilyRepository|RepositoryProxy repository()
 * @method static Family[]|Proxy[]                 all()
 * @method static Family[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Family[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Family[]|Proxy[]                 findBy(array $attributes)
 * @method static Family[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Family[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Family> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Family> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Family> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Family> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Family> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Family> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Family> random(array $attributes = [])
 * @phpstan-method static Proxy<Family> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Family> repository()
 * @phpstan-method static list<Proxy<Family>> all()
 * @phpstan-method static list<Proxy<Family>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Family>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Family>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Family>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Family>> randomSet(int $number, array $attributes = [])
 */
final class FamilyFactory extends ModelFactory
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
            'address' => self::faker()->address(),
            'city' => 'Lyon',
            'country' => 'France',
            'email' => self::faker()->email(),
            'familyName' => self::faker()->lastName(),
            'phone' => self::faker()->phoneNumber(),
            'zipCode' => self::faker()->postcode(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Family $family): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Family::class;
    }
}
