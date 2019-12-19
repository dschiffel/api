<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class AppUser implements UserInterface
{
    public function getRoles()
    {
        return ['ROLE_APP', 'ROLE_USER'];
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return 'app';
    }

    public function eraseCredentials()
    {

    }
}
