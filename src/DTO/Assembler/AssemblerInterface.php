<?php

namespace App\DTO\Assembler;

interface AssemblerInterface
{
    /**
     * @param object $object
     * @param object $target
     * @return object
     */
    public function fromDTO($object, $target = null);

    /**
     * @param object $entity
     * @param
     * @return object
     */
    public function toDTO($entity);
}
