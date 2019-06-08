<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class AttributeDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"application_view"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"application_view"})
     *
     * @var string
     */
    public $title;

    /**
     * @Serializer\Type("array<string, App\DTO\ValueDTO>")
     * @Serializer\Groups({"application_view"})
     *
     * @var ValueDTO[]
     */
    public $values;
}
