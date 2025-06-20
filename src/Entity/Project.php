<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255)]
    private ?string $name = null;

    #[ORM\Column(type:"text")]
    private ?string $description = null;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private ?string $imageFilename = null;

    #[Assert\Url]
    #[ORM\Column(name: "prod_url", type: "string", length: 255, nullable: true)]
    private ?string $prodUrl = null;

    #[Assert\Url]
    #[ORM\Column(name: "preprod_url", type:"string", length:255 , nullable: true)]
    private ?string $preprodUrl = null;

    // Getters & setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
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

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;
        return $this;
    }

    public function getProdUrl(): ?string
    {
        return $this->prodUrl;
    }

    public function setProdUrl(?string $prodUrl): self
    {
     if ($prodUrl) {
        $url = preg_replace('#^https?://#', '', $prodUrl);
        $prodUrl = 'https://' . $url;
    }
    $this->prodUrl = $prodUrl;
    return $this;
    }

    public function getPreprodUrl(): ?string
    {
        return $this->preprodUrl;
    }

    public function setPreprodUrl(?string $preprodUrl): self
    {
     if ($preprodUrl) {
        $url = preg_replace('#^https?://#', '', $preprodUrl);
        $preprodUrl = 'http://' . $url;
    }
    $this->preprodUrl = $preprodUrl;
    return $this;
    }
}   // src/Entity/Project.php

   