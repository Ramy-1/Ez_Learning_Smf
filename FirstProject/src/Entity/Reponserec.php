<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponserec
 *
 * @ORM\Table(name="reponserec", indexes={@ORM\Index(name="fk_reclamation", columns={"idreclamation"})})
 * @ORM\Entity
 */
class Reponserec
{
    /**
     * @var int
     *
     * @ORM\Column(name="idreponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreponse;

    /**
     * @var int
     *
     * @ORM\Column(name="idreclamation", type="integer", nullable=false)
     */
    private $idreclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="daterep", type="date", nullable=false)
     */
    private $daterep;

    public function getIdreponse(): ?int
    {
        return $this->idreponse;
    }

    public function getIdreclamation(): ?int
    {
        return $this->idreclamation;
    }

    public function setIdreclamation(int $idreclamation): self
    {
        $this->idreclamation = $idreclamation;

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

    public function getDaterep(): ?\DateTimeInterface
    {
        return $this->daterep;
    }

    public function setDaterep(\DateTimeInterface $daterep): self
    {
        $this->daterep = $daterep;

        return $this;
    }


}
