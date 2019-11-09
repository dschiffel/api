<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class AttributeDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"state_view"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"state_view"})
     *
     * @var string
     */
    public $title;

    /**
     * @Serializer\Type("array<string, App\DTO\ValueDTO>")
     * @Serializer\Groups({"state_view"})
     *
     * @var StateDTO[]
     */
    public $values;
}
