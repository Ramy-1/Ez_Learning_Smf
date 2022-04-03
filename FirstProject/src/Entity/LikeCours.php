<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LikeCours
 *
 * @ORM\Table(name="like_cours")
 * @ORM\Entity
 */
class LikeCours
{
    /**
     * @var int
     *
     * @ORM\Column(name="idLike", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlike;

    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var int
     *
     * @ORM\Column(name="like_etat", type="integer", nullable=false)
     */
    private $likeEtat;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    public function getIdlike(): ?int
    {
        return $this->idlike;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getLikeEtat(): ?int
    {
        return $this->likeEtat;
    }

    public function setLikeEtat(int $likeEtat): self
    {
        $this->likeEtat = $likeEtat;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }


}
