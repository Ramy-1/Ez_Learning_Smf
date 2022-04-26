<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message=" nom doit etre non vide")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 5,
     *      minMessage=" Entrer un nom au mini de 5 caracteres"
     *
     *     )
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="adresse", type="string", length=200, nullable=false)
     * @Assert\Length(
     *      min = 4,
     *      minMessage=" Entrer une adresse au mini de 4 caracteres"
     *     )
     */
    private $adresse;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="imguni", type="string", length=200, nullable=false)
     */
    private $imguni;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="mdpuni", type="string", length=200, nullable=false)
     * @Assert\Length(
     *      min = 3,
     *      minMessage=" Entrer un mdpuni au mini de 3 caracteres"
     *     )
     */
    private $mdpuni;

    /**
     * @return int
     */
    public function getIduni(): int
    {
        return $this->iduni;
    }

    /**
     * @param int $iduni
     */
    public function setIduni(int $iduni): void
    {
        $this->iduni = $iduni;
    }

    /**
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getImguni(): ?string
    {
        return $this->imguni;
    }

    /**
     * @param string $imguni
     */
    public function setImguni(string $imguni): void
    {
        $this->imguni = $imguni;
    }

    /**
     * @return string
     */
    public function getMdpuni(): ?string
    {
        return $this->mdpuni;
    }

    /**
     * @param string $mdpuni
     */
    public function setMdpuni(string $mdpuni): void
    {
        $this->mdpuni = $mdpuni;
    }


}
