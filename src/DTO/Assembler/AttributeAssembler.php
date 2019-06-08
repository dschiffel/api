<?php

namespace App\DTO\Assembler;

use App\DTO\AttributeDTO;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\Attribute;
use App\Repository\ValueRepository;

class AttributeAssembler implements AssemblerInterface
{
    /**
     * @var ValueRepository
     */
    private $valueRepository;

    /**
     * @var ValueAssembler
     */
    private $valueAssembler;

    /**
     * @param ValueRepository $valueRepository
     * @param ValueAssembler $valueAssembler
     */
    public function __construct(ValueRepository $valueRepository, ValueAssembler $valueAssembler)
    {
        $this->valueRepository = $valueRepository;
        $this->valueAssembler = $valueAssembler;
    }

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
        $attributeDTO->values = $this->getValues($entity);

        return $attributeDTO;
    }

    /**
     * @param Attribute $attribute
     * @return array
     */
    private function getValues(Attribute $attribute)
    {
        $values = [];
        $valueEntities = $this->valueRepository->findValuesForAttribute($attribute);

        foreach ($valueEntities as $valueEntity) {
            $values[$valueEntity->getEnvironment()->getId()] = $this->valueAssembler->toDTO($valueEntity);
        }

        return $values;
    }
}
