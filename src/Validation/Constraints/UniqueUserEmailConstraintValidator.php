<?php declare(strict_types=1);

namespace App\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserEmailConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // todo validate
    }
}
