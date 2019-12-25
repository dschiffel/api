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
        $token = $this->genAccessToken();

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

    /**
     * Generates an unique access token.
     *
     * @return string An unique access token.
     *
     * @ingroup oauth2_section_4
     * @see     OAuth2::genAuthCode()
     */
    protected function genAccessToken()
    {
        if (@file_exists('/dev/urandom')) { // Get 100 bytes of random data
            $randomData = file_get_contents('/dev/urandom', false, null, 0, 100);
        } elseif (function_exists('openssl_random_pseudo_bytes')) { // Get 100 bytes of pseudo-random data
            $bytes = openssl_random_pseudo_bytes(100, $strong);
            if (true === $strong && false !== $bytes) {
                $randomData = $bytes;
            }
        }
        // Last resort: mt_rand
        if (empty($randomData)) { // Get 108 bytes of (pseudo-random, insecure) data
            $randomData = mt_rand() . mt_rand() . mt_rand() . uniqid(mt_rand(), true) . microtime(true) . uniqid(
                    mt_rand(),
                    true
                );
        }

        return rtrim(strtr(base64_encode(hash('sha256', $randomData)), '+/', '-_'), '=');
    }
}
