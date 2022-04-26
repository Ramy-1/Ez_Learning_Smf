<?php

namespace App\Entity;

use App\Repository\UserFavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserFavoriteRepository::class)
 */
class UserFavorite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="userFavorites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Cours::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $cour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCour(): ?cours
    {
        return $this->cour;
    }

    public function setCour(?cours $cour): self
    {
        $this->cour = $cour;

        return $this;
    }
}
