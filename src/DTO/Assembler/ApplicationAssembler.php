<?php

namespace App\DTO\Assembler;

use App\DTO\ApplicationDTO;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\Application;

class ApplicationAssembler implements AssemblerInterface
{
    /**
     * @var EnvironmentAssembler
     */
    private $environmentAssembler;

    /**
     * @var AttributeAssembler;
     */
    private $attributeAssembler;

    /**
     * @param EnvironmentAssembler $environmentAssembler
     * @param AttributeAssembler $attributeAssembler
     */
    public function __construct(
        EnvironmentAssembler $environmentAssembler,
        AttributeAssembler $attributeAssembler
    ) {
        $this->environmentAssembler = $environmentAssembler;
        $this->attributeAssembler = $attributeAssembler;
    }

    /**
     * @inheritDoc
     */
    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof ApplicationDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', ApplicationDTO::class));
        }

        if ($target === null) {
            $target = new Application();
        }

        $target
            ->setTitle($object->title);

        foreach ($object->environments as $environmentDTO) {
            $target->addEnvironment($this->environmentAssembler->fromDTO($environmentDTO));
        }

        foreach ($object->attributes as $attributeDTO) {
            $target->addAttribute($this->attributeAssembler->fromDTO($attributeDTO));
        }

        return $target;
    }

    /**
     * @inheritDoc
     */
    public function toDTO($entity)
    {
        if (!$entity instanceof Application) {
            throw new InvalidArgumentException(sprintf('%s expected', Application::class));
        }

        $applicationDTO = new ApplicationDTO();

        $applicationDTO->id = $entity->getId();
        $applicationDTO->title = $entity->getTitle();

        if (!$entity->getEnvironments()->isEmpty()) {
            $applicationDTO->environments = [];
            foreach ($entity->getEnvironments() as $environment) {
                $applicationDTO->environments[] = $this->environmentAssembler->toDTO($environment);
            }
        }

        if (!$entity->getAttributes()->isEmpty()) {
            $applicationDTO->attributes = [];
            foreach ($entity->getAttributes() as $attribute) {
                $applicationDTO->attributes[] = $this->attributeAssembler->toDTO($attribute);
            }
        }

        return $applicationDTO;
    }
}
