<?php

namespace App\DTO\Assembler;

use App\DTO\DeployAttributeDTO;
use App\DTO\Exception\AssemblerException;
use App\DTO\Exception\AssemblingException;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\DeployAttribute;
use App\Repository\AttributeRepository;

class DeployAttributeAssembler implements AssemblerInterface
{
    private $attributeAssembler;

    private $attributeRepository;

    public function __construct(AttributeAssembler $attributeAssembler, AttributeRepository $attributeRepository)
    {
        $this->attributeAssembler = $attributeAssembler;
        $this->attributeRepository = $attributeRepository;
    }

    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof DeployAttributeDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', DeployAttributeDTO::class));
        }

        if ($target === null) {
            $target = new DeployAttribute();
        }

        if (is_string($object->attribute)) {
            $attribute = $this->attributeRepository->findOneBy(['title' => $object->attribute]);
            if ($attribute === null) {
                throw new AssemblerException('Attribute not found');
            }
        } else {
            $attribute = $this->attributeAssembler->fromDTO($object->attribute);
        }
        $target->setAttribute($attribute);
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
