<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeployRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Deploy
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
     * @ORM\OneToMany(targetEntity="DeployAttribute", mappedBy="deploy", cascade={"persist"})
     */
    private $deployAttributes;

    public function __construct()
    {
        $this->deployAttributes = new ArrayCollection();
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
     * @return Collection|DeployAttribute[]
     */
    public function getDeployAttributes(): Collection
    {
        return $this->deployAttributes;
    }

    public function addDeployAttribute(DeployAttribute $deployAttribute): self
    {
        if (!$this->deployAttributes->contains($deployAttribute)) {
            $this->deployAttributes[] = $deployAttribute;
            $deployAttribute->setDeploy($this);
        }

        return $this;
    }

    public function removeDeployAttribute(DeployAttribute $deployAttribute): self
    {
        if ($this->deployAttributes->contains($deployAttribute)) {
            $this->deployAttributes->removeElement($deployAttribute);
            // set the owning side to null (unless already changed)
            if ($deployAttribute->getDeploy() === $this) {
                $deployAttribute->setDeploy(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime();
        }
    }
}
