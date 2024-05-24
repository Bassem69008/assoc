<?php

namespace App\Factory\Users;

use App\Entity\Users\User;
use App\Entity\Users\UserBack;
use App\Repository\Users\UserBackRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<UserBack>
 *
 * @method        UserBack|Proxy                     create(array|callable $attributes = [])
 * @method static UserBack|Proxy                     createOne(array $attributes = [])
 * @method static UserBack|Proxy                     find(object|array|mixed $criteria)
 * @method static UserBack|Proxy                     findOrCreate(array $attributes)
 * @method static UserBack|Proxy                     first(string $sortedField = 'id')
 * @method static UserBack|Proxy                     last(string $sortedField = 'id')
 * @method static UserBack|Proxy                     random(array $attributes = [])
 * @method static UserBack|Proxy                     randomOrCreate(array $attributes = [])
 * @method static UserBackRepository|RepositoryProxy repository()
 * @method static UserBack[]|Proxy[]                 all()
 * @method static UserBack[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static UserBack[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static UserBack[]|Proxy[]                 findBy(array $attributes)
 * @method static UserBack[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static UserBack[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<UserBack> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<UserBack> createOne(array $attributes = [])
 * @phpstan-method static Proxy<UserBack> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<UserBack> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<UserBack> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<UserBack> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<UserBack> random(array $attributes = [])
 * @phpstan-method static Proxy<UserBack> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<UserBack> repository()
 * @phpstan-method static list<Proxy<UserBack>> all()
 * @phpstan-method static list<Proxy<UserBack>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<UserBack>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<UserBack>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<UserBack>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<UserBack>> randomSet(int $number, array $attributes = [])
 */
final class UserBackFactory extends ModelFactory
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
        $user = new UserBack();

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
            // ->afterInstantiate(function(UserBack $userBack): void {})
        ;
    }

    protected static function getClass(): string
    {
        return UserBack::class;
    }
}
