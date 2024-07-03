<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Classroom>
     */
    #[ORM\ManyToMany(targetEntity: Classroom::class, inversedBy: 'subjects')]
    private Collection $classroom;

    #[ORM\ManyToOne(inversedBy: 'subjects')]
    private ?Teacher $teacher = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->classroom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Classroom>
     */
    public function getClassroom(): Collection
    {
        return $this->classroom;
    }

    public function addClassroom(Classroom $classroom): static
    {
        if (!$this->classroom->contains($classroom)) {
            $this->classroom->add($classroom);
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): static
    {
        $this->classroom->removeElement($classroom);

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): static
    {
        $this->teacher = $teacher;

        return $this;
    }
}
