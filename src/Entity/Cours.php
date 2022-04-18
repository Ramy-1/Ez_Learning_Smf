<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Cours
 *
 * @ORM\Table(name="cours")
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
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
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+"
     * )
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
     * @Assert\Positive
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreate", type="datetime", length=200, nullable=false, options={"default"="current_timestamp()"})
     */
    private $datecreate;

    /**
     * @var string
     *
     * @ORM\Column(name="support", type="string", length=200, nullable=false)
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url."
     * )
     */
    private $support;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="idcat", type="integer", nullable=false)
     */
    private $idcat;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDuree(): ?string
    {
        return $this->duree;
    }

    /**
     * @param string $duree
     */
    public function setDuree(string $duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @return string
     */
    public function getDatecreate(): ?\DateTimeInterface
    {
        return $this->datecreate;
    }

    /**
     * @param string $datecreate
     */
    public function setDatecreate(\DateTimeInterface $datecreate): void
    {
        $this->datecreate = $datecreate;
    }

    /**
     * @return string
     */
    public function getSupport(): ?string
    {
        return $this->support;
    }

    /**
     * @param string $support
     */
    public function setSupport(string $support): void
    {
        $this->support = $support;
    }

    /**
     * @return int
     */
    public function getEtat(): ?int
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat(int $etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return int
     */
    public function getIdcat(): ?int
    {
        return $this->idcat;
    }

    /**
     * @param int $idcat
     */
    public function setIdcat(int $idcat): void
    {
        $this->idcat = $idcat;
    }


}
