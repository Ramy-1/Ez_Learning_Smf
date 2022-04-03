<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultattest
 *
 * @ORM\Table(name="resultattest")
 * @ORM\Entity
 */
class Resultattest
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
     * @var int
     *
     * @ORM\Column(name="idtest", type="integer", nullable=false)
     */
    private $idtest;

    /**
     * @var int
     *
     * @ORM\Column(name="idetudiant", type="integer", nullable=false)
     */
    private $idetudiant;

    /**
     * @var float
     *
     * @ORM\Column(name="score", type="float", precision=10, scale=0, nullable=false)
     */
    private $score;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdtest(): ?int
    {
        return $this->idtest;
    }

    public function setIdtest(int $idtest): self
    {
        $this->idtest = $idtest;

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

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }


}
