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

    /**
     * @return int
     */
    public function getIdlike(): int
    {
        return $this->idlike;
    }

    /**
     * @param int $idlike
     */
    public function setIdlike(int $idlike): void
    {
        $this->idlike = $idlike;
    }

    /**
     * @return int
     */
    public function getIduser(): int
    {
        return $this->iduser;
    }

    /**
     * @param int $iduser
     */
    public function setIduser(int $iduser): void
    {
        $this->iduser = $iduser;
    }

    /**
     * @return int
     */
    public function getLikeEtat(): int
    {
        return $this->likeEtat;
    }

    /**
     * @param int $likeEtat
     */
    public function setLikeEtat(int $likeEtat): void
    {
        $this->likeEtat = $likeEtat;
    }

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


}
