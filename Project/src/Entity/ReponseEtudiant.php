<?php

namespace App\Entity;

use App\Repository\ReponseEtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseEtudiantRepository::class)
 */
class ReponseEtudiant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCorrect;

    /**
     * @ORM\ManyToOne(targetEntity=Reponses::class, inversedBy="reponseEtudiants")
     */
    private $reponse;

    /**
     * @ORM\ManyToOne(targetEntity=Questions::class, inversedBy="reponseEtudiants")
     */
    private $question;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function getReponse(): ?Reponses
    {
        return $this->reponse;
    }

    public function setReponse(?Reponses $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    public function setQuestion(?Questions $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }
}
