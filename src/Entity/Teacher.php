<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column]
    private ?string $lastName = null;

    #[ORM\Column]
    private ?string $firstName = null;

    #[ORM\Column]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $phone = null;

    /**
     * @var Collection<int, Classroom>
     */
    #[ORM\OneToMany(targetEntity: Classroom::class, mappedBy: 'teacher')]
    private Collection $classrooms;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->classrooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Classroom>
     */
    public function getClassrooms(): Collection
    {
        return $this->classrooms;
    }

    public function addClassroom(Classroom $classroom): static
    {
        if (!$this->classrooms->contains($classroom)) {
            $this->classrooms->add($classroom);
            $classroom->setTeacher($this);
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): static
    {
        if ($this->classrooms->removeElement($classroom)) {
            // set the owning side to null (unless already changed)
            if ($classroom->getTeacher() === $this) {
                $classroom->setTeacher(null);
            }
        }

        return $this;
    }
}
