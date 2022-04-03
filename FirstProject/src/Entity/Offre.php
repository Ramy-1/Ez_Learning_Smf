<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity
 */
class Offre
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
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date", nullable=false)
     */
    private $datefin;

    /**
     * @var int
     *
     * @ORM\Column(name="nbPlace", type="integer", nullable=false)
     */
    private $nbplace;

    /**
     * @var int
     *
     * @ORM\Column(name="nbDemande", type="integer", nullable=false)
     */
    private $nbdemande;

    /**
     * @var int
     *
     * @ORM\Column(name="nbAccepted", type="integer", nullable=false)
     */
    private $nbaccepted;

    /**
     * @var int
     *
     * @ORM\Column(name="idRecruteur", type="integer", nullable=false)
     */
    private $idrecruteur;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getNbplace(): ?int
    {
        return $this->nbplace;
    }

    public function setNbplace(int $nbplace): self
    {
        $this->nbplace = $nbplace;

        return $this;
    }

    public function getNbdemande(): ?int
    {
        return $this->nbdemande;
    }

    public function setNbdemande(int $nbdemande): self
    {
        $this->nbdemande = $nbdemande;

        return $this;
    }

    public function getNbaccepted(): ?int
    {
        return $this->nbaccepted;
    }

    public function setNbaccepted(int $nbaccepted): self
    {
        $this->nbaccepted = $nbaccepted;

        return $this;
    }

    public function getIdrecruteur(): ?int
    {
        return $this->idrecruteur;
    }

    public function setIdrecruteur(int $idrecruteur): self
    {
        $this->idrecruteur = $idrecruteur;

        return $this;
    }


}
