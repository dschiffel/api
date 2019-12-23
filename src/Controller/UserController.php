<?php

namespace App\Controller;

use App\DTO\Assembler\UserAssembler;
use App\DTO\UserDTO;
use App\Form\RegistrationType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/user/")
     * @Security("has_role('ROLE_APP')")
     */
    public function getAuthenticatedUserAction(TokenStorageInterface $tokenStorage, UserAssembler $userAssembler)
    {
        $user = $tokenStorage->getToken()->getUser();

        $userDTO = $userAssembler->toDTO($user);

        $view = $this->view(['user' => $userDTO]);
        $view->getContext()->addGroup('auth_user');

        return $view;
    }

    /**
     * @Rest\Post("/register")
     */
    public function register(
        UserAssembler $userAssembler,
        UserPasswordEncoderInterface $encoder,
        Request $request
    ) {
        $userDto = new UserDTO();
        $form = $this->createForm(RegistrationType::class, $userDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userAssembler->fromDTO($userDto);
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->view();
        }

        throw new UnprocessableEntityHttpException();
    }
}
