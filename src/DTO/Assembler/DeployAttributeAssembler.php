<?php

namespace App\DTO\Assembler;

use App\DTO\DeployAttributeDTO;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\DeployAttribute;

class DeployAttributeAssembler implements AssemblerInterface
{
    private $attributeAssembler;

    public function __construct(AttributeAssembler $attributeAssembler)
    {
        $this->attributeAssembler = $attributeAssembler;
    }

    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof DeployAttributeDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', DeployAttributeDTO::class));
        }

        if ($target === null) {
            $target = new DeployAttribute();
        }

        $target->setAttribute($this->attributeAssembler->fromDTO($object->attribute));
        $target->setValue($object->value);

        return $target;
    }

    public function toDTO($entity)
    {
        if (!$entity instanceof DeployAttribute) {
            throw new InvalidArgumentException(sprintf('%s expected', DeployAttribute::class));
        }

        $deployAttributeDTO = new DeployAttributeDTO();

        $deployAttributeDTO->id = $entity->getId();
        $deployAttributeDTO->attribute = $this->attributeAssembler->toDTO($entity->getAttribute());
        $deployAttributeDTO->value = $entity->getValue();

        return $deployAttributeDTO;
    }
}
