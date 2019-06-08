<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class ValueDTO
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
    public $value;
}
