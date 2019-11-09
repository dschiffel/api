<?php

namespace App\DTO\Assembler;

use App\DTO\DeployDTO;
use App\DTO\Exception\AssemblerException;
use App\DTO\Exception\InvalidArgumentException;
use App\Entity\Deploy;
use App\Repository\EnvironmentRepository;

class DeployAssembler implements AssemblerInterface
{
    private $environmentAssembler;

    private $deployAttributeAssembler;

    private $environmentRepository;

    public function __construct(
        EnvironmentAssembler $environmentAssembler,
        DeployAttributeAssembler $deployAttributeAssembler,
        EnvironmentRepository $environmentRepository
    ) {
        $this->environmentAssembler = $environmentAssembler;
        $this->deployAttributeAssembler = $deployAttributeAssembler;
        $this->environmentRepository = $environmentRepository;
    }

    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof DeployDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', DeployDTO::class));
        }

        if ($target === null) {
            $target = new Deploy();
        }

        if (is_string($object->environment)) {
            // todo scope with application
            $environment = $this->environmentRepository->findOneBy(['title' => $object->environment]);
            if ($environment === null) {
                throw new AssemblerException('Environment not found');
            }
        } else {
            $environment = $this->environmentAssembler->fromDTO($object->environment);
        }
        $target->setEnvironment($environment);
        if ($object->deployAttributes) {
            foreach ($object->deployAttributes as $deployAttributeDTO) {
                $target->addDeployAttribute($this->deployAttributeAssembler->fromDTO($deployAttributeDTO));
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
