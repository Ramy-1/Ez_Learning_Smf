<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcat;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string", length=50, nullable=false)
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+"
     * )
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="nomcat", type="string", length=50, nullable=false)
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+"
     * )
     */
    private $nomcat;

    /**
     * @return int
     */
    public function getIdcat(): int
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

    /**
     * @return string
     */
    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    /**
     * @param string $domaine
     */
    public function setDomaine(string $domaine): void
    {
        $this->domaine = $domaine;
    }

    /**
     * @return string
     */
    public function getNomcat(): ?string
    {
        return $this->nomcat;
    }

    /**
     * @param string $nomcat
     */
    public function setNomcat(string $nomcat): void
    {
        $this->nomcat = $nomcat;
    }


}
