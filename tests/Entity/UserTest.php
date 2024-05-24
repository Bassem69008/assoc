<?php

namespace App\Tests\Entity;

use App\Entity\Users\User;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public static function getUser(): User
    {
        $user = new User();
        $user->setFirstName('Bassem');
        $user->setLastName('Rahali');
        $user->setEmail('admin@example.com');

        return $user;
    }

    public function assertEntityHasErrors(User $entity, int $expectedErrorsNumber): void
    {
        $errors = $this->validator->validate($entity);
        $messages = [];
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().'=>'.$error->getMessage();
        }
        $this->assertCount($expectedErrorsNumber, $errors, implode(', ', $messages));
    }

    public function testValidEntity(): void
    {
        $this->assertEntityHasErrors(self::getUser(), 0);
    }

    public function testInvalidEntityEmptyAttributes(): void
    {
        $this->assertEntityHasErrors(self::getUser()->setFirstName(''), 1);
        $this->assertEntityHasErrors(self::getUser()->setLastname(''), 1);
        $this->assertEntityHasErrors(self::getUser()->setEmail(''), 1);
    }

    private function truncateEntities(): void
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }

    protected function tearDown(): void
    {
        $this->truncateEntities();
        parent::tearDown();
    }
}
