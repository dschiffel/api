<?php

namespace App\Controller;

use App\DTO\Assembler\UserAssembler;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/user/")
     *
     * @param TokenStorageInterface $tokenStorage
     * @param UserAssembler $userAssembler
     * @return View
     */
    public function getUserAction(TokenStorageInterface $tokenStorage, UserAssembler $userAssembler)
    {
        $user = $tokenStorage->getToken()->getUser();

        $userDTO = $userAssembler->toDTO($user);

        return $this->view(['user' => $userDTO]);
    }
}
