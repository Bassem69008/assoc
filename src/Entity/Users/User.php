<?php

declare(strict_types=1);

namespace App\Entity\Users;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
class User implements PasswordAuthenticatedUserInterface
{
    public const PASSWORD_NOT_SET = 'Password69007!';

    #[ORM\Column]
    #[Assert\NotBlank]
    protected ?string $lastName = null;
    #[ORM\Column]
    #[Assert\NotBlank]
    protected ?string $firstName = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email]
    #[Assert\NotBlank]
    protected ?string $email = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    protected ?string $password = self::PASSWORD_NOT_SET;
    #[ORM\Column]
    protected ?bool $isVerified = false;

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
