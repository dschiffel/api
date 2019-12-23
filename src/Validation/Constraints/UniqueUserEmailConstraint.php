<?php declare(strict_types=1);

namespace App\Validation\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class UniqueUserEmailConstraint extends Constraint
{
}
