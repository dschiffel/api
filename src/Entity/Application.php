<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 */
class Application
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Environment",
     *     mappedBy="application",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     */
    private $environments;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Attribute",
     *     mappedBy="application",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     */
    private $attributes;

    public function __construct()
    {
        $this->environments = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Environment[]
     */
    public function getEnvironments(): Collection
    {
        return $this->environments;
    }

    public function addEnvironment(Environment $environment): self
    {
        if (!$this->environments->contains($environment)) {
            $this->environments[] = $environment;
            $environment->setApplication($this);
        }

        return $this;
    }

    public function removeEnvironment(Environment $environment): self
    {
        if ($this->environments->contains($environment)) {
            $this->environments->removeElement($environment);
            // set the owning side to null (unless already changed)
            if ($environment->getApplication() === $this) {
                $environment->setApplication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Attribute[]
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(Attribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setApplication($this);
        }

        return $this;
    }

    public function removeAttribute(Attribute $attribute): self
    {
        if ($this->attributes->contains($attribute)) {
            $this->attributes->removeElement($attribute);
            // set the owning side to null (unless already changed)
            if ($attribute->getApplication() === $this) {
                $attribute->setApplication(null);
            }
        }

        return $this;
    }
}
