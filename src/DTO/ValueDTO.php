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
     * @Serializer\Type("integer")
     *
     * @var int
     */
    public $environmentId;

    /**
     * @Serializer\Type("integer")
     *
     * @var int
     */
    public $attributeId;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"application_view"})
     *
     * @var string
     */
    public $value;
}
