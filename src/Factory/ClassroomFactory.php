<?php

namespace App\Factory;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Classroom>
 *
 * @method        Classroom|Proxy                     create(array|callable $attributes = [])
 * @method static Classroom|Proxy                     createOne(array $attributes = [])
 * @method static Classroom|Proxy                     find(object|array|mixed $criteria)
 * @method static Classroom|Proxy                     findOrCreate(array $attributes)
 * @method static Classroom|Proxy                     first(string $sortedField = 'id')
 * @method static Classroom|Proxy                     last(string $sortedField = 'id')
 * @method static Classroom|Proxy                     random(array $attributes = [])
 * @method static Classroom|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ClassroomRepository|RepositoryProxy repository()
 * @method static Classroom[]|Proxy[]                 all()
 * @method static Classroom[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Classroom[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Classroom[]|Proxy[]                 findBy(array $attributes)
 * @method static Classroom[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Classroom[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Classroom> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Classroom> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Classroom> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Classroom> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Classroom> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Classroom> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Classroom> random(array $attributes = [])
 * @phpstan-method static Proxy<Classroom> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Classroom> repository()
 * @phpstan-method static list<Proxy<Classroom>> all()
 * @phpstan-method static list<Proxy<Classroom>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Classroom>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Classroom>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Classroom>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Classroom>> randomSet(int $number, array $attributes = [])
 */
final class ClassroomFactory extends ModelFactory
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
            'name' => self::faker()->randomElement(['classe1', 'classe2', 'classe3']),
            'startHour' => new \DateTime(self::faker()->time('H:i:s')),
            'endHour' => new \DateTime(self::faker()->time('H:i:s')),
            'teacher' => TeacherFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Classroom $classroom): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Classroom::class;
    }
}
