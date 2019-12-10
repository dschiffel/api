<?php

namespace App\DTO\Assembler;

use App\DTO\Exception\InvalidArgumentException;
use App\DTO\StateDTO;
use App\Entity\State;

class StateAssembler implements AssemblerInterface
{
    private $environmentAssembler;

    private $attributeAssembler;

    public function __construct(EnvironmentAssembler $environmentAssembler, AttributeAssembler $attributeAssembler)
    {
        $this->environmentAssembler = $environmentAssembler;
        $this->attributeAssembler = $attributeAssembler;
    }

    /**
     * @inheritDoc
     */
    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof StateDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', StateDTO::class));
        }

        if ($target === null) {
            $target = new State();
        }

        $target->setValue($object->value);
        $target->setUpdatedAt($object->updatedAt);
        if ($object->environment) {
            $target->setEnvironment($this->environmentAssembler->fromDTO($object->environment));
        }
        if ($object->attribute) {
            $target->setAttribute($this->attributeAssembler->fromDTO($object->attribute));
        }

        return $target;
    }

    /**
     * @inheritDoc
     */
    public function toDTO($entity)
    {
        if (!$entity instanceof State) {
            throw new InvalidArgumentException(sprintf('%s expected', State::class));
        }

        $stateDTO = new StateDTO();

        $stateDTO->id = $entity->getId();
        $stateDTO->value = $entity->getValue();
        $stateDTO->updatedAt = $entity->getUpdatedAt();
        $stateDTO->environment = $this->environmentAssembler->toDTO($entity->getEnvironment());
        $stateDTO->attribute = $this->attributeAssembler->toDTO($entity->getAttribute());

        return $stateDTO;
    }
}
