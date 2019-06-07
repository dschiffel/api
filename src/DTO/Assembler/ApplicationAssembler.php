<?php

namespace App\DTO\Assembler;

use App\DTO\ApplicationDTO;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\Application;
use App\Entity\Attribute;
use App\Entity\Environment;
use App\Entity\Value;
use App\Repository\ValueRepository;

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
     * @var ValueRepository
     */
    private $valueRepository;

    /**
     * @param EnvironmentAssembler $environmentAssembler
     * @param AttributeAssembler $attributeAssembler
     * @param ValueRepository $valueRepository
     */
    public function __construct(
        EnvironmentAssembler $environmentAssembler,
        AttributeAssembler $attributeAssembler,
        ValueRepository $valueRepository
    ) {
        $this->environmentAssembler = $environmentAssembler;
        $this->attributeAssembler = $attributeAssembler;
        $this->valueRepository = $valueRepository;
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

        $applicationDTO->valueMap = $this->getValueMap($entity);

        return $applicationDTO;
    }

    /**
     * @param Application $application
     * @return array
     */
    private function getValueMap(Application $application)
    {
        $valueMap = [];
        $environments = $application->getEnvironments();
        $attributes = $application->getAttributes();
        $values = $this->valueRepository->findApplicationValues($application);

        /**
         * @param Environment $environment
         * @param Attribute $attribute
         * @return string|null
         */
        $search = function (Environment $environment, Attribute $attribute) use ($values) {
            foreach ($values as $value) {
                if ($value->getEnvironment() === $environment && $value->getAttribute() === $attribute) {
                    return $value->getValue();
                }
            }

            return null;
        };

        foreach ($environments as $environment) {
            foreach ($attributes as $attribute) {
                $valueMap[$attribute->getTitle()][$environment->getTitle()] = $search($environment, $attribute);
            }
        }

        return $valueMap;
    }
}
