<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeployAttributeRepository")
 */
class DeployAttribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Deploy", inversedBy="releaseAttributes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Attribute")
     * @ORM\JoinColumn(nullable=false)
     */
    private $attribute;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRel(): ?Deploy
    {
        return $this->rel;
    }

    public function setRel(?Deploy $rel): self
    {
        $this->rel = $rel;

        return $this;
    }

    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(?Attribute $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
