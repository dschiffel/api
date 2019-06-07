<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class ApplicationDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"application_list", "application_view"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"application_list", "application_view"})
     *
     * @var string
     */
    public $title;

    /**
     * @Serializer\Type("array<App\DTO\EnvironmentDTO>")
     * @Serializer\Groups({"application_view"})
     *
     * @var EnvironmentDTO[]
     */
    public $environments;

    /**
     * @Serializer\Type("array<App\DTO\AttributeDTO>")
     * @Serializer\Groups({"application_view"})
     *
     * @var AttributeDTO[]
     */
    public $attributes;

    /**
     * @Serializer\ReadOnly()
     * @Serializer\Type("array<string, array<string, string>>")
     * @Serializer\Groups({"application_view"})
     *
     * @var array
     */
    public $valueMap;
}
