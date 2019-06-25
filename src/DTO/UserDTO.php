<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class UserDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"user_view"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"user_view"})
     *
     * @var string
     */
    public $email;
}
