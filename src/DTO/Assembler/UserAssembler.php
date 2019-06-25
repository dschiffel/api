<?php

namespace App\DTO\Assembler;

use App\DTO\UserDTO;
use App\Entity\User;
use InvalidArgumentException;

class UserAssembler implements AssemblerInterface
{
    /**
     * @inheritDoc
     */
    public function fromDTO($object, $target = null)
    {
        if (!$object instanceof UserDTO) {
            throw new InvalidArgumentException(sprintf('%s expected', UserDTO::class));
        }

        if ($target === null) {
            $target = new User();
        }

        $target
            ->setEmail($object->email);

        return $target;
    }

    /**
     * @inheritDoc
     */
    public function toDTO($entity)
    {
        if (!$entity instanceof User) {
            throw new InvalidArgumentException(sprintf('%s expected', User::class));
        }

        $userDTO = new UserDTO();

        $userDTO->id = $entity->getId();
        $userDTO->email = $entity->getEmail();

        return $userDTO;
    }
}
