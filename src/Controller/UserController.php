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
    public function getAuthenticatedUserAction(TokenStorageInterface $tokenStorage, UserAssembler $userAssembler)
    {
        $user = $tokenStorage->getToken()->getUser();

        $userDTO = $userAssembler->toDTO($user);

        $view = $this->view(['user' => $userDTO]);
        $view->getContext()->addGroup('auth_user');

        return $view;
    }
}
