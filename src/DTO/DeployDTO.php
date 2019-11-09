<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class DeployDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"deploy_list"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("App\DTO\EnvironmentDTO")
     * @Serializer\Groups({"deploy_list"})
     *
     * @var EnvironmentDTO
     */
    public $environment;

    /**
     * @Serializer\Type("array<App\DTO\DeployAttributeDTO>")
     * @Serializer\Groups({"deploy_list"})
     *
     * @var DeployAttributeDTO[]
     */
    public $deployAttributes;

    /**
     * @Serializer\Type("DateTime")
     * @Serializer\Groups({"deploy_list"})
     *
     * @var \DateTime
     */
    public $createdAt;
}
