<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class StateDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"state_list"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("App\DTO\AttributeDTO")
     * @Serializer\Groups({"state_list"})
     *
     * @var int
     */
    public $environment;

    /**
     * @Serializer\Type("App\DTO\AttributeDTO")
     * @Serializer\Groups({"state_list"})
     *
     * @var int
     */
    public $attribute;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"state_list"})
     *
     * @var string
     */
    public $value;

    /**
     * @Serializer\Type("DateTime")
     * @Serializer\Groups({"state_list"})
     *
     * @var \DateTime
     */
    public $updatedAt;
}
