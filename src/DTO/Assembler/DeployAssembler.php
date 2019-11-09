<?php

namespace App\DTO\Assembler;

use App\DTO\DeployDTO;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\Deploy;

class DeployAssembler implements AssemblerInterface
{
    private $environmentAssembler;

    private $deployAttributeAssembler;

    public function __construct(
        EnvironmentAssembler $environmentAssembler,
        DeployAttributeAssembler $deployAttributeAssembler
    ) {
        $this->environmentAssembler = $environmentAssembler;
        $this->deployAttributeAssembler = $deployAttributeAssembler;
    }

    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof DeployDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', DeployDTO::class));
        }

        if ($target === null) {
            $target = new Deploy();
        }

        $target->setEnvironment($this->environmentAssembler->fromDTO($object->environment));
        if ($object->deployAttributes) {
            foreach ($object->deployAttributes as $deployAttributeDTO) {
                $target->addDeployeAttribute($this->deployAttributeAssembler->fromDTO($deployAttributeDTO));
            }
        }

        return $target;
    }

    public function toDTO($entity)
    {
        if (!$entity instanceof Deploy) {
            throw new InvalidArgumentException(sprintf('%s expected', Deploy::class));
        }

        $deployDTO = new DeployDTO();

        $deployDTO->id = $entity->getId();
        $deployDTO->environment = $this->environmentAssembler->toDTO($entity->getEnvironment());
        $deployDTO->createdAt = $entity->getCreatedAt();

        if (!$entity->getDeployAttributes()->isEmpty()) {
            $deployDTO->deployAttributes = [];
            foreach ($entity->getDeployAttributes() as $deployAttribute) {
                $deployDTO->deployAttributes[] = $this->deployAttributeAssembler->toDTO($deployAttribute);
            }
        }

        return $deployDTO;
    }
}
