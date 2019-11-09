<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributeRepository")
 */
class Attribute
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Application", inversedBy="attributes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $application;

    /**
     * @ORM\OneToMany(targetEntity="State", mappedBy="attribute", orphanRemoval=true)
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
     * @return Collection|State[]
     */
    public function getValueList(): Collection
    {
        return $this->valueList;
    }

    public function addValueList(State $valueList): self
    {
        if (!$this->valueList->contains($valueList)) {
            $this->valueList[] = $valueList;
            $valueList->setAttribute($this);
        }

        return $this;
    }

    public function removeValueList(State $valueList): self
    {
        if ($this->valueList->contains($valueList)) {
            $this->valueList->removeElement($valueList);
            // set the owning side to null (unless already changed)
            if ($valueList->getAttribute() === $this) {
                $valueList->setAttribute(null);
            }
        }

        return $this;
    }
}
