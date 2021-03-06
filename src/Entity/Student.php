<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $nsc;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Get creative and think of an email!")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="students", cascade={"remove"})
     */
    private $classroom;

    /**
     * @ORM\ManyToMany(targetEntity=Club::class, inversedBy="students")
     *  @ORM\JoinTable(name="students_clubs",
     *      joinColumns={@ORM\JoinColumn(name="student_id", referencedColumnName="nsc")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="club_id", referencedColumnName="ref")}
     *      )
     */
    private $clubs;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getNsc()
    {
        return $this->nsc;
    }

    /**
     * @param mixed $nsc
     */
    public function setNsc($nsc): void
    {
        $this->nsc = $nsc;
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

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * @return Collection|Club[]
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs[] = $club;
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        if ($this->clubs->contains($club)) {
            $this->clubs->removeElement($club);
        }

        return $this;
    }

    public function __toString()
    {
        return(string)$this->getEmail();
    }

}
