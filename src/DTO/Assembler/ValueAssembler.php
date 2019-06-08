<?php

namespace App\DTO\Assembler;

use App\DTO\Exception\InvalidArgumentException;
use App\DTO\ValueDTO;
use App\Entity\Value;
use App\Repository\AttributeRepository;
use App\Repository\EnvironmentRepository;

class ValueAssembler implements AssemblerInterface
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
        if (!$object instanceof ValueDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', ValueDTO::class));
        }

        if ($target === null) {
            $target = new Value();
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
        if (!$entity instanceof Value) {
            throw new InvalidArgumentException(sprintf('%s expected', Value::class));
        }

        $valueDTO = new ValueDTO();

        $valueDTO->id = $entity->getId();
        $valueDTO->value = $entity->getValue();
        $valueDTO->environmentId = $entity->getEnvironment()->getId();
        $valueDTO->attributeId = $entity->getAttribute()->getId();

        return $valueDTO;
    }
}
