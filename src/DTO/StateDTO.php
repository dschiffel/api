<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class StateDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"state_view"})
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
     * @Serializer\Groups({"state_view", "value_edit"})
     *
     * @var string
     */
    public $value;
}
