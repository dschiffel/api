<?php declare(strict_types=1);

namespace App\Security\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class EmailNotConfirmedException extends AccountStatusException
{
    public function getMessageKey()
    {
        return 'Email not confirmed';
    }
}
