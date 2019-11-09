<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReleaseRepository")
 */
class Release
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Environment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $environment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReleaseAttribute", mappedBy="rel")
     */
    private $releaseAttributes;

    public function __construct()
    {
        $this->releaseAttributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    public function setEnvironment(?Environment $environment): self
    {
        $this->environment = $environment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|ReleaseAttribute[]
     */
    public function getReleaseAttributes(): Collection
    {
        return $this->releaseAttributes;
    }

    public function addReleaseAttribute(ReleaseAttribute $releaseAttribute): self
    {
        if (!$this->releaseAttributes->contains($releaseAttribute)) {
            $this->releaseAttributes[] = $releaseAttribute;
            $releaseAttribute->setRel($this);
        }

        return $this;
    }

    public function removeReleaseAttribute(ReleaseAttribute $releaseAttribute): self
    {
        if ($this->releaseAttributes->contains($releaseAttribute)) {
            $this->releaseAttributes->removeElement($releaseAttribute);
            // set the owning side to null (unless already changed)
            if ($releaseAttribute->getRel() === $this) {
                $releaseAttribute->setRel(null);
            }
        }

        return $this;
    }
}
