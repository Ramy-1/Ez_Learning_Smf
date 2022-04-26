<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestionsRepository::class)
 * @Vich\Uploadable
 */
class Questions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="questions")
     * ORM\JoinColumn(name="test_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $test;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $support;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $supportUpdatedAt;

    /**
     * @Assert\File(maxSize="2M")
     * @Vich\UploadableField(mapping="questions", fileNameProperty="support")
     * @var File
     */
    private $supportFile;

    /**
     * @ORM\OneToMany(targetEntity=Reponses::class, mappedBy="question")
     */
    private $reponses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=ReponseEtudiant::class, mappedBy="question")
     */
    private $reponseEtudiants;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
        $this->reponseEtudiants = new ArrayCollection();
    }

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

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setSupportFile(File $support = null)
     {
         $this->supportFile = $support;

         if ($support) {
             
             $this->supportUpdatedAt = new \DateTime('now');
         }
     }
 
     public function getSupportFile()
     {
         return $this->supportFile;
     }
 
     public function setSupport($support)
     {
         $this->support = $support;
     }
 
     public function getSupport()
     {
         return $this->support;
     }

     /**
      * @return Collection<int, Reponses>
      */
     public function getReponses(): Collection
     {
         return $this->reponses;
     }

     public function addReponse(Reponses $reponse): self
     {
         if (!$this->reponses->contains($reponse)) {
             $this->reponses[] = $reponse;
             $reponse->setQuestion($this);
         }

         return $this;
     }

     public function removeReponse(Reponses $reponse): self
     {
         if ($this->reponses->removeElement($reponse)) {
             // set the owning side to null (unless already changed)
             if ($reponse->getQuestion() === $this) {
                 $reponse->setQuestion(null);
             }
         }

         return $this;
     }

     public function getType(): ?string
     {
         return $this->type;
     }

     public function setType(string $type): self
     {
         $this->type = $type;

         return $this;
     }

     /**
      * @return Collection<int, ReponseEtudiant>
      */
     public function getReponseEtudiants(): Collection
     {
         return $this->reponseEtudiants;
     }

     public function addReponseEtudiant(ReponseEtudiant $reponseEtudiant): self
     {
         if (!$this->reponseEtudiants->contains($reponseEtudiant)) {
             $this->reponseEtudiants[] = $reponseEtudiant;
             $reponseEtudiant->setQuestion($this);
         }

         return $this;
     }

     public function removeReponseEtudiant(ReponseEtudiant $reponseEtudiant): self
     {
         if ($this->reponseEtudiants->removeElement($reponseEtudiant)) {
             // set the owning side to null (unless already changed)
             if ($reponseEtudiant->getQuestion() === $this) {
                 $reponseEtudiant->setQuestion(null);
             }
         }

         return $this;
     }

}
