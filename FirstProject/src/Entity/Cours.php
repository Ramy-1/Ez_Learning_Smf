<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours")
 * @ORM\Entity
 */
class Cours
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
     * @ORM\Column(name="titre", type="string", length=100, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=200, nullable=false)
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="datecreate", type="string", length=200, nullable=false)
     */
    private $datecreate;

    /**
     * @var string
     *
     * @ORM\Column(name="support", type="string", length=200, nullable=false)
     */
    private $support;

    /**
     * @var int
     *
     * @ORM\Column(name="idcat", type="integer", nullable=false)
     */
    private $idcat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDatecreate(): ?string
    {
        return $this->datecreate;
    }

    public function setDatecreate(string $datecreate): self
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getIdcat(): ?int
    {
        return $this->idcat;
    }

    public function setIdcat(int $idcat): self
    {
        $this->idcat = $idcat;

        return $this;
    }


}
