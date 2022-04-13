<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande")
 * @ORM\Entity
 */
class Demande
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
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="pathCv", type="string", length=255, nullable=false)
     */
    private $pathcv;

    /**
     * @var int
     *
     * @ORM\Column(name="idOffre", type="integer", nullable=false)
     */
    private $idoffre;

    /**
     * @var int
     *
     * @ORM\Column(name="idEtudiant", type="integer", nullable=false)
     */
    private $idetudiant;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPathcv(): ?string
    {
        return $this->pathcv;
    }

    public function setPathcv(string $pathcv): self
    {
        $this->pathcv = $pathcv;

        return $this;
    }

    public function getIdoffre(): ?int
    {
        return $this->idoffre;
    }

    public function setIdoffre(int $idoffre): self
    {
        $this->idoffre = $idoffre;

        return $this;
    }

    public function getIdetudiant(): ?int
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(int $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }


}
