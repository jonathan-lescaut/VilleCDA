<?php

namespace App\Entity;

use App\Repository\PresentationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresentationRepository::class)]
class Presentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titrePresentation;

    #[ORM\Column(type: 'string', length: 255)]
    private $logoPresentation;

    #[ORM\Column(type: 'text')]
    private $imgPresentation;

    #[ORM\Column(type: 'string', length: 255)]
    private $imgPresentation1;

    #[ORM\Column(type: 'string', length: 255)]
    private $imgPresentation2;

    #[ORM\Column(type: 'string', length: 255)]
    private $imgPresentation3;

    #[ORM\Column(type: 'string', length: 255)]
    private $imgPresentation4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitrePresentation(): ?string
    {
        return $this->titrePresentation;
    }

    public function setTitrePresentation(string $titrePresentation): self
    {
        $this->titrePresentation = $titrePresentation;

        return $this;
    }

    public function getLogoPresentation(): ?string
    {
        return $this->logoPresentation;
    }

    public function setLogoPresentation(string $logoPresentation): self
    {
        $this->logoPresentation = $logoPresentation;

        return $this;
    }

    public function getImgPresentation(): ?string
    {
        return $this->imgPresentation;
    }

    public function setImgPresentation(string $imgPresentation): self
    {
        $this->imgPresentation = $imgPresentation;

        return $this;
    }

    public function getImgPresentation1(): ?string
    {
        return $this->imgPresentation1;
    }

    public function setImgPresentation1(string $imgPresentation1): self
    {
        $this->imgPresentation1 = $imgPresentation1;

        return $this;
    }

    public function getImgPresentation2(): ?string
    {
        return $this->imgPresentation2;
    }

    public function setImgPresentation2(string $imgPresentation2): self
    {
        $this->imgPresentation2 = $imgPresentation2;

        return $this;
    }

    public function getImgPresentation3(): ?string
    {
        return $this->imgPresentation3;
    }

    public function setImgPresentation3(string $imgPresentation3): self
    {
        $this->imgPresentation3 = $imgPresentation3;

        return $this;
    }

    public function getImgPresentation4(): ?string
    {
        return $this->imgPresentation4;
    }

    public function setImgPresentation4(string $imgPresentation4): self
    {
        $this->imgPresentation4 = $imgPresentation4;

        return $this;
    }
}
