<?php

namespace App\Factory\Users;

use App\Entity\Users\User;
use App\Repository\Users\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<User>
 *
 * @method        User|Proxy                     create(array|callable $attributes = [])
 * @method static User|Proxy                     createOne(array $attributes = [])
 * @method static User|Proxy                     find(object|array|mixed $criteria)
 * @method static User|Proxy                     findOrCreate(array $attributes)
 * @method static User|Proxy                     first(string $sortedField = 'id')
 * @method static User|Proxy                     last(string $sortedField = 'id')
 * @method static User|Proxy                     random(array $attributes = [])
 * @method static User|Proxy                     randomOrCreate(array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method static User[]|Proxy[]                 all()
 * @method static User[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static User[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static User[]|Proxy[]                 findBy(array $attributes)
 * @method static User[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static User[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<User> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<User> createOne(array $attributes = [])
 * @phpstan-method static Proxy<User> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<User> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<User> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<User> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<User> random(array $attributes = [])
 * @phpstan-method static Proxy<User> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<User> repository()
 * @phpstan-method static list<Proxy<User>> all()
 * @phpstan-method static list<Proxy<User>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<User>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<User>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<User>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<User>> randomSet(int $number, array $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
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
        $user = new User();

        return [
            'lastName' => self::faker()->lastName(),
            'firstName' => self::faker()->firstName(),
            'email' => self::faker()->text(180),
            'password' => $this->passwordEncoder->hashPassword($user, User::PASSWORD_NOT_SET),
            'isVerified' => self::faker()->boolean(),
            'roles' => [],
            'createdAt' => self::faker()->dateTime(),
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(User $User): void {})
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
