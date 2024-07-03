<?php

namespace App\Factory;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Subject>
 *
 * @method        Subject|Proxy                              create(array|callable $attributes = [])
 * @method static Subject|Proxy                              createOne(array $attributes = [])
 * @method static Subject|Proxy                              find(object|array|mixed $criteria)
 * @method static Subject|Proxy                              findOrCreate(array $attributes)
 * @method static Subject|Proxy                              first(string $sortedField = 'id')
 * @method static Subject|Proxy                              last(string $sortedField = 'id')
 * @method static Subject|Proxy                              random(array $attributes = [])
 * @method static Subject|Proxy                              randomOrCreate(array $attributes = [])
 * @method static SubjectRepository|ProxyRepositoryDecorator repository()
 * @method static Subject[]|Proxy[]                          all()
 * @method static Subject[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Subject[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Subject[]|Proxy[]                          findBy(array $attributes)
 * @method static Subject[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Subject[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Subject&Proxy<Subject> create(array|callable $attributes = [])
 * @phpstan-method static Subject&Proxy<Subject> createOne(array $attributes = [])
 * @phpstan-method static Subject&Proxy<Subject> find(object|array|mixed $criteria)
 * @phpstan-method static Subject&Proxy<Subject> findOrCreate(array $attributes)
 * @phpstan-method static Subject&Proxy<Subject> first(string $sortedField = 'id')
 * @phpstan-method static Subject&Proxy<Subject> last(string $sortedField = 'id')
 * @phpstan-method static Subject&Proxy<Subject> random(array $attributes = [])
 * @phpstan-method static Subject&Proxy<Subject> randomOrCreate(array $attributes = [])
 * @phpstan-method static ProxyRepositoryDecorator<Subject, EntityRepository> repository()
 * @phpstan-method static list<Subject&Proxy<Subject>> all()
 * @phpstan-method static list<Subject&Proxy<Subject>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Subject&Proxy<Subject>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Subject&Proxy<Subject>> findBy(array $attributes)
 * @phpstan-method static list<Subject&Proxy<Subject>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Subject&Proxy<Subject>> randomSet(int $number, array $attributes = [])
 */
final class SubjectFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Subject::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @return array<string, mixed>|callable
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->text(25),
            'teacher' => TeacherFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Subject $subject): void {})
        ;
    }
}
