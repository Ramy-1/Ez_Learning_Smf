<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var string
     *
     * @ORM\Column(name="idOrg", type="string", length=30, nullable=false)
     */
    private $idorg;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=100, nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="heure", type="string", length=100, nullable=false)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=200, nullable=false)
     */
    private $lien;

    /**
     * @var string
     *
     * @ORM\Column(name="imgEv", type="string", length=200, nullable=false)
     */
    private $imgev;

    public function getIdevent(): ?int
    {
        return $this->idevent;
    }

    public function getIdorg(): ?string
    {
        return $this->idorg;
    }

    public function setIdorg(string $idorg): self
    {
        $this->idorg = $idorg;

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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(string $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getImgev(): ?string
    {
        return $this->imgev;
    }

    public function setImgev(string $imgev): self
    {
        $this->imgev = $imgev;

        return $this;
    }


}
