<?php declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Security\Exception\EmailNotConfirmedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EmailConfirmedUserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->getEmailConfirmed()) {
            throw new EmailNotConfirmedException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        return;
    }
}
