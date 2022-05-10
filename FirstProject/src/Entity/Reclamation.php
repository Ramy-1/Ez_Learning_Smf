<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="fk_cours", columns={"idcours"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="TYPE is required") 
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     * @Assert\NotBlank(message="DESCRIPTION is required") 
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="idetudiant", type="string", length=200, nullable=false)
     * 
     */
    private $idetudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="idcours", type="string", length=200, nullable=false)
     */
    private $idcours;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="daterec", type="date", nullable=false)
     */
    private $daterec;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdetudiant(): ?string
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(string $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }

    public function getIdcours(): ?string
    {
        return $this->idcours;
    }

    public function setIdcours(string $idcours): self
    {
        $this->idcours = $idcours;

        return $this;
    }

    public function getDaterec(): ?\DateTimeInterface
    {
        return $this->daterec;
    }

    public function setDaterec(\DateTimeInterface $daterec): self
    {
        $this->daterec = $daterec;

        return $this;
    }


}
