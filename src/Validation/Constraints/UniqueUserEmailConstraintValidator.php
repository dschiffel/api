<?php declare(strict_types=1);

namespace App\Validation\Constraints;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserEmailConstraintValidator extends ConstraintValidator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        $exists = $this->userRepository->count(['email' => $value]);

        if ($exists > 0) {
            $this->context->addViolation(sprintf('Email % is already registered', $value));
        }
    }
}
