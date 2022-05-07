<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
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
     * @Assert\NotBlank
     * @ORM\Column(name="idOrg", type="string", length=30, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 7,
     *      minMessage = "doit etre >=2 ",
     *      maxMessage = "doit etre <=7" )
     *   )
     */
    private $idorg;

    /**
     * @Assert\NotBlank(message="description  doit etre non vide")
     * @Assert\Length(
     *      min = 7,
     *      max = 100,
     *      minMessage = "doit etre >=7 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @var string A "Y-m-d" formatted value
     * @Assert\GreaterThan("today", message="La date de l'évènement doit être ultérieur à la date d'aujourd'hui")
     *@Assert\NotBlank
     */
    private $date;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="heure", type="string", length=100, nullable=false)
     *@Assert\Length(min=1,max=2)
     */
    private $heure;

    /**
     * @var string
     * @ORM\Column(name="lien", type="string", length=200, nullable=false)
      * @Assert\NotBlank
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url."
     * )
     */
    private $lien;

    /**
     * @var string
     * @ORM\Column(name="imgEv", type="string", length=200, nullable=false)
     * @Assert\NotBlank
     *@Assert\Length(min=4,max=32)
     */
    private $imgev;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrParticipant", type="integer", nullable=false)
     * @Assert\NotBlank
     * @Assert\Positive
     *
     */
    private $nbrparticipant;

    /**
     * @var int|null
     * @Assert\NotBlank
     * @ORM\Column(name="idUni", type="integer", nullable=true)
     */
    private $iduni;

    /**
     * @return string
     */
    public function getHeure(): ?string
    {
        return $this->heure;
    }

    /**
     * @param string $heure
     */
    public function setHeure(string $heure): void
    {
        $this->heure = $heure;
    }

    /**
     * @return int
     */
    public function getIdevent(): int
    {
        return $this->idevent;
    }

    /**
     * @param int $idevent
     */
    public function setIdevent(int $idevent): void
    {
        $this->idevent = $idevent;
    }

    /**
     * @return string
     */
    public function getIdorg(): ?string
    {
        return $this->idorg;
    }

    /**
     * @param string $idorg
     */
    public function setIdorg(string $idorg): void
    {
        $this->idorg = $idorg;
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
     * @return \DateTime
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getLien(): ?string
    {
        return $this->lien;
    }

    /**
     * @param string $lien
     */
    public function setLien(string $lien): void
    {
        $this->lien = $lien;
    }

    /**
     * @return string
     */
    public function getImgev()
    {
        return $this->imgev;
    }

    /**
     * @param string $imgev
     */
    public function setImgev(string $imgev): void
    {
        $this->imgev = $imgev;
    }

    /**
     * @return int
     */
    public function getNbrparticipant(): ?int
    {
        return $this->nbrparticipant;
    }

    /**
     * @param int $nbrparticipant
     */
    public function setNbrparticipant(int $nbrparticipant): void
    {
        $this->nbrparticipant = $nbrparticipant;
    }

    /**
     * @return int|null
     */
    public function getIduni(): ?int
    {
        return $this->iduni;
    }

    /**
     * @param int|null $iduni
     */
    public function setIduni(?int $iduni): void
    {
        $this->iduni = $iduni;
    }


}
