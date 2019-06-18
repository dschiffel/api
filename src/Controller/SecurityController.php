<?php

namespace App\Controller;

use App\Entity\AccessToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/login")
     *
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     * @return View
     */
    public function loginAction(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        /** @var User $user */
        $user = $tokenStorage->getToken()->getUser();

        $em->getRepository(AccessToken::class)->removeUserTokens($user);

        $createdAt = new \DateTimeImmutable();
        $expiresAt = $createdAt->modify('+30 days');
        $token = base64_encode(random_bytes(64));

        $accessToken = new AccessToken();
        $accessToken
            ->setToken($token)
            ->setUser($user)
            ->setCreatedAt($createdAt)
            ->setExpiresAt($expiresAt);

        $em->persist($accessToken);
        $em->flush();

        return $this->view(['access_token' => $accessToken->getToken()]);
    }
}
