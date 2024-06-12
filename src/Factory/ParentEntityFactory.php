<?php

namespace App\Factory;

use App\Entity\ParentEntity;
use App\Repository\ParentEntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ParentEntity>
 *
 * @method        ParentEntity|Proxy                     create(array|callable $attributes = [])
 * @method static ParentEntity|Proxy                     createOne(array $attributes = [])
 * @method static ParentEntity|Proxy                     find(object|array|mixed $criteria)
 * @method static ParentEntity|Proxy                     findOrCreate(array $attributes)
 * @method static ParentEntity|Proxy                     first(string $sortedField = 'id')
 * @method static ParentEntity|Proxy                     last(string $sortedField = 'id')
 * @method static ParentEntity|Proxy                     random(array $attributes = [])
 * @method static ParentEntity|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ParentEntityRepository|RepositoryProxy repository()
 * @method static ParentEntity[]|Proxy[]                 all()
 * @method static ParentEntity[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static ParentEntity[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static ParentEntity[]|Proxy[]                 findBy(array $attributes)
 * @method static ParentEntity[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static ParentEntity[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<ParentEntity> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<ParentEntity> createOne(array $attributes = [])
 * @phpstan-method static Proxy<ParentEntity> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<ParentEntity> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<ParentEntity> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<ParentEntity> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<ParentEntity> random(array $attributes = [])
 * @phpstan-method static Proxy<ParentEntity> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<ParentEntity> repository()
 * @phpstan-method static list<Proxy<ParentEntity>> all()
 * @phpstan-method static list<Proxy<ParentEntity>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<ParentEntity>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<ParentEntity>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<ParentEntity>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<ParentEntity>> randomSet(int $number, array $attributes = [])
 */
final class ParentEntityFactory extends ModelFactory
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
            'family' => FamilyFactory::random(),
            'lastName' => self::faker()->lastName(),
            'firstName' => self::faker()->firstName(),
            'gender' => self::faker()->randomElement(['M', 'F']),
            'email' => self::faker()->email(),
            'phone' => self::faker()->phoneNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ParentEntity $parentEntity): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ParentEntity::class;
    }
}
