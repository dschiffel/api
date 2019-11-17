<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

class UserDTO
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"auth_user"})
     *
     * @var int
     */
    public $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"auth_user"})
     *
     * @var string
     */
    public $email;
}
