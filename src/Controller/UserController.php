<?php

namespace App\Controller;

use App\DTO\Assembler\UserAssembler;
use App\DTO\UserDTO;
use App\Entity\ActionToken;
use App\Entity\User;
use App\Exception\ApiException;
use App\Exception\FormException;
use App\Form\UserType;
use App\Mailer\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
    public function registerAction(
        UserAssembler $userAssembler,
        UserPasswordEncoderInterface $encoder,
        Mailer $mailer,
        Request $request
    ) {
        $userDto = new UserDTO();
        $form = $this->createForm(UserType::class, $userDto, ['validation_groups' => 'register']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userAssembler->fromDTO($userDto);
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $actionToken = new ActionToken();
            $actionToken
                ->setAction(ActionToken::ACTION_CONFIRM_REGISTRATION)
                ->setUser($user);
            $em->persist($actionToken);
            $em->flush();

            $mailer->sendConfirmationEmail($actionToken);

            return $this->view();
        }

        throw new FormException($form->getErrors(true));
    }

    /**
     * @Rest\Post("/confirm/{token}")
     */
    public function confirmAction(
        EntityManagerInterface $em,
        string $token
    ) {
        $actionToken = $em->getRepository(ActionToken::class)->findOneBy([
            'action' => ActionToken::ACTION_CONFIRM_REGISTRATION,
            'token' => $token,
        ]);

        if ($actionToken === null) {
            throw new BadRequestHttpException('Something went wrong');
        }

        if (!$actionToken->getActive()) {
            throw new BadRequestHttpException('Email already confirmed');
        }

        $user = $actionToken->getUser();
        $user->setEmailConfirmed(true);
        $actionToken->setActive(false);

        $em->flush();

        return $this->view();
    }
}
