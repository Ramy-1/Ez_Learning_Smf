<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity
 */
class Evaluation
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
     * @ORM\Column(name="idformateur", type="integer", nullable=false)
     */
    private $idformateur;

    /**
     * @var int
     *
     * @ORM\Column(name="idformation", type="integer", nullable=false)
     */
    private $idformation;

    /**
     * @var float
     *
     * @ORM\Column(name="eval", type="float", precision=10, scale=0, nullable=false)
     */
    private $eval;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdformateur(): ?int
    {
        return $this->idformateur;
    }

    public function setIdformateur(int $idformateur): self
    {
        $this->idformateur = $idformateur;

        return $this;
    }

    public function getIdformation(): ?int
    {
        return $this->idformation;
    }

    public function setIdformation(int $idformation): self
    {
        $this->idformation = $idformation;

        return $this;
    }

    public function getEval(): ?float
    {
        return $this->eval;
    }

    public function setEval(float $eval): self
    {
        $this->eval = $eval;

        return $this;
    }


}
