<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity
 */
class Questions
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
     * @ORM\Column(name="contenu", type="string", length=255, nullable=false)
     */
    private $contenu;

    /**
     * @var int
     *
     * @ORM\Column(name="testid", type="integer", nullable=false)
     */
    private $testid;

    /**
     * @var string
     *
     * @ORM\Column(name="reponses", type="string", length=255, nullable=false)
     */
    private $reponses;

    /**
     * @var int
     *
     * @ORM\Column(name="reponsecorrect", type="integer", nullable=false)
     */
    private $reponsecorrect;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=false)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getTestid(): ?int
    {
        return $this->testid;
    }

    public function setTestid(int $testid): self
    {
        $this->testid = $testid;

        return $this;
    }

    public function getReponses(): ?string
    {
        return $this->reponses;
    }

    public function setReponses(string $reponses): self
    {
        $this->reponses = $reponses;

        return $this;
    }

    public function getReponsecorrect(): ?int
    {
        return $this->reponsecorrect;
    }

    public function setReponsecorrect(int $reponsecorrect): self
    {
        $this->reponsecorrect = $reponsecorrect;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }


}
