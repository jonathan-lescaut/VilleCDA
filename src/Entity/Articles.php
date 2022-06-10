<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Categories;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticlesRepository;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nameArticles;

    #[ORM\Column(type: 'text')]
    private $contenuArticles;

    #[ORM\ManyToOne(targetEntity: Categories::class, inversedBy: 'articles')]
    private $Categories;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'articles')]
    private $User;

    #[ORM\Column(type: 'string', length: 255)]
    private $resumeArticles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameArticles(): ?string
    {
        return $this->nameArticles;
    }

    public function setNameArticles(string $nameArticles): self
    {
        $this->nameArticles = $nameArticles;

        return $this;
    }

    public function getContenuArticles(): ?string
    {
        return $this->contenuArticles;
    }

    public function setContenuArticles(string $contenuArticles): self
    {
        $this->contenuArticles = $contenuArticles;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->Categories;
    }

    public function setCategories(?Categories $Categories): self
    {
        $this->Categories = $Categories;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getResumeArticles(): ?string
    {
        return $this->resumeArticles;
    }

    public function setResumeArticles(string $resumeArticles): self
    {
        $this->resumeArticles = $resumeArticles;

        return $this;
    }
}
