<?php

namespace App\DTO\Assembler;

use App\DTO\AttributeDTO;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\Attribute;

class AttributeAssembler implements AssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof AttributeDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', AttributeDTO::class));
        }

        if ($target === null) {
            $target = new Attribute();
        }

        $target->setTitle($object->title);

        return $target;
    }

    /**
     * @inheritDoc
     */
    public function toDTO($entity)
    {
        if (!$entity instanceof Attribute) {
            throw new InvalidArgumentException(sprintf('%s expected', Attribute::class));
        }

        $attributeDTO = new AttributeDTO();

        $attributeDTO->id = $entity->getId();
        $attributeDTO->title = $entity->getTitle();

        return $attributeDTO;
    }
}
