<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Universite
 *
 * @ORM\Table(name="universite")
 * @ORM\Entity
 */
class Universite
{
    /**
     * @var int
     *
     * @ORM\Column(name="idUni", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduni;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=200, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="imguni", type="string", length=200, nullable=false)
     */
    private $imguni;

    /**
     * @var string
     *
     * @ORM\Column(name="mdpuni", type="string", length=200, nullable=false)
     */
    private $mdpuni;

    public function getIduni(): ?int
    {
        return $this->iduni;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getImguni(): ?string
    {
        return $this->imguni;
    }

    public function setImguni(string $imguni): self
    {
        $this->imguni = $imguni;

        return $this;
    }

    public function getMdpuni(): ?string
    {
        return $this->mdpuni;
    }

    public function setMdpuni(string $mdpuni): self
    {
        $this->mdpuni = $mdpuni;

        return $this;
    }


}
