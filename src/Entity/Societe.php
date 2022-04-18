<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Societe
 *
 * @ORM\Table(name="societe")
 * @ORM\Entity
 */
class Societe
{
    /**
     * @var string
     *
     * @ORM\Column(name="idsoc", type="string", length=200, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsoc;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="emails", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=250, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="imgsoc", type="string", length=250, nullable=false)
     */
    private $imgsoc;

    /**
     * @var string
     *
     * @ORM\Column(name="mdpsoc", type="string", length=200, nullable=false)
     */
    private $mdpsoc;

    public function getIdsoc(): ?string
    {
        return $this->idsoc;
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

    public function getImgsoc(): ?string
    {
        return $this->imgsoc;
    }

    public function setImgsoc(string $imgsoc): self
    {
        $this->imgsoc = $imgsoc;

        return $this;
    }

    public function getMdpsoc(): ?string
    {
        return $this->mdpsoc;
    }

    public function setMdpsoc(string $mdpsoc): self
    {
        $this->mdpsoc = $mdpsoc;

        return $this;
    }


}
