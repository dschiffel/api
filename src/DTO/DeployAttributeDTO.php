<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class DeployAttributeDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"deploy_list"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("App\DTO\AttributeDTO")
     * @Serializer\Groups({"deploy_list"})
     *
     * @var AttributeDTO
     */
    public $attribute;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"deploy_list"})
     *
     * @var string
     */
    public $value;
}
