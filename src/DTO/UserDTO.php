<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validation\Constraints as AppAssert;

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
     * @Assert\NotBlank(groups={"register"})
     * @Assert\Email(groups={"register"})
     * @AppAssert\UniqueUserEmailConstraint(groups={"register"})
     * @Serializer\Type("string")
     * @Serializer\Groups({"auth_user"})
     *
     * @var string
     */
    public $email;

    /**
     * @Assert\NotBlank(groups={"register"})
     * todo password policy
     * @Serializer\Type("string")
     *
     * @var string
     */
    public $password;
}
