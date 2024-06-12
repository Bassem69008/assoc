<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Please enter your family name')]
    private ?string $familyName = null;

    #[ORM\Column]
    private ?string $address = null;

    #[ORM\Column]
    private ?string $city = null;

    #[ORM\Column]
    private ?string $zipCode = null;

    #[ORM\Column]
    private ?string $country = null;

    #[ORM\Column]
    private ?string $phone = null;

    #[ORM\Column]
    #[Assert\Email]
    #[Assert\NotBlank(message: 'Please enter your email address')]
    private ?string $email = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'family', orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $students;

    /**
     * @var Collection<int, ParentEntity>
     */
    #[ORM\OneToMany(targetEntity: ParentEntity::class, mappedBy: 'family', orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Assert\Count(max: 2, maxMessage : 'You can specify a maximum of 2 parents')]
    private Collection $parentEntities;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->students = new ArrayCollection();
        $this->parentEntities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): static
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setFamily($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getFamily() === $this) {
                $student->setFamily(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParentEntity>
     */
    public function getParentEntities(): Collection
    {
        return $this->parentEntities;
    }

    public function addParentEntity(ParentEntity $parentEntity): static
    {
        if (\count($this->parentEntities) > 2) {
            throw new \LogicException('Cannot add more than 2 parent entities to a family.');
        }
        if (!$this->parentEntities->contains($parentEntity)) {
            $this->parentEntities->add($parentEntity);
            $parentEntity->setFamily($this);
        }

        return $this;
    }

    public function removeParentEntity(ParentEntity $parentEntity): static
    {
        if ($this->parentEntities->removeElement($parentEntity)) {
            // set the owning side to null (unless already changed)
            if ($parentEntity->getFamily() === $this) {
                $parentEntity->setFamily(null);
            }
        }

        return $this;
    }
}
