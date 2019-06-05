<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnvironmentRepository")
 */
class Environment
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Application", inversedBy="environments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $application;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Value", mappedBy="environment", orphanRemoval=true)
     */
    private $valueList;

    public function __construct()
    {
        $this->valueList = new ArrayCollection();
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

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): self
    {
        $this->application = $application;

        return $this;
    }

    /**
     * @return Collection|Value[]
     */
    public function getValueList(): Collection
    {
        return $this->valueList;
    }

    public function addValueList(Value $valueList): self
    {
        if (!$this->valueList->contains($valueList)) {
            $this->valueList[] = $valueList;
            $valueList->setEnvironment($this);
        }

        return $this;
    }

    public function removeValueList(Value $valueList): self
    {
        if ($this->valueList->contains($valueList)) {
            $this->valueList->removeElement($valueList);
            // set the owning side to null (unless already changed)
            if ($valueList->getEnvironment() === $this) {
                $valueList->setEnvironment(null);
            }
        }

        return $this;
    }
}
