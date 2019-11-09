<?php

namespace App\DTO\Assembler;

use App\DTO\Exception\InvalidArgumentException;
use App\DTO\StateDTO;
use App\Entity\State;
use App\Repository\AttributeRepository;
use App\Repository\EnvironmentRepository;

class StateAssembler implements AssemblerInterface
{
    /**
     * @var EnvironmentRepository
     */
    private $environmentRepository;

    /**
     * @var AttributeRepository
     */
    private $attributeRepository;

    /**
     * @param EnvironmentRepository $environmentRepository
     * @param AttributeRepository $attributeRepository
     */
    public function __construct(EnvironmentRepository $environmentRepository, AttributeRepository $attributeRepository)
    {
        $this->environmentRepository = $environmentRepository;
        $this->attributeRepository = $attributeRepository;
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
        if ($object->environmentId) {
            $target->setEnvironment($this->environmentRepository->find($object->environmentId));
        }
        if ($object->attributeId) {
            $target->setAttribute($this->attributeRepository->find($object->attributeId));
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

        $valueDTO = new StateDTO();

        $valueDTO->id = $entity->getId();
        $valueDTO->value = $entity->getValue();
        $valueDTO->environmentId = $entity->getEnvironment()->getId();
        $valueDTO->attributeId = $entity->getAttribute()->getId();

        return $valueDTO;
    }
}
