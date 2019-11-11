<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class EnvironmentDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"state_list", "deploy_list"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"state_list", "deploy_list"})
     *
     * @var string
     */
    public $title;
}
