<?php

namespace App\DTO\Assembler;

use App\DTO\EnvironmentDTO;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\Environment;

class EnvironmentAssembler implements AssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof EnvironmentDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', EnvironmentDTO::class));
        }

        if ($target === null) {
            $target = new Environment();
        }

        $target->setTitle($object->title);

        return $target;
    }

    /**
     * @inheritDoc
     */
    public function toDTO($entity)
    {
        if (!$entity instanceof Environment) {
            throw new InvalidArgumentException(sprintf('%s expected', Environment::class));
        }

        $environmentDTO = new EnvironmentDTO();

        $environmentDTO->id = $entity->getId();
        $environmentDTO->title = $entity->getTitle();

        return $environmentDTO;
    }
}
