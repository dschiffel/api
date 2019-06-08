<?php

namespace App\DTO\Assembler;

use App\DTO\Exception\InvalidArgumentException;
use App\DTO\ValueDTO;
use App\Entity\Value;

class ValueAssembler implements AssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof ValueDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', ValueDTO::class));
        }

        if ($target === null) {
            $target = new Value();
        }

        $target->setValue($object->value);

        return $target;
    }

    /**
     * @inheritDoc
     */
    public function toDTO($entity)
    {
        if (!$entity instanceof Value) {
            throw new InvalidArgumentException(sprintf('%s expected', Value::class));
        }

        $valueDTO = new ValueDTO();

        $valueDTO->id = $entity->getId();
        $valueDTO->value = $entity->getValue();

        return $valueDTO;
    }
}
