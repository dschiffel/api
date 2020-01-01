<?php declare(strict_types=1);

namespace App\Mailer;

use App\Entity\ActionToken;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
    /**
     * @var MailerInterface
     */
    private $symfonyMailer;

    /**
     * @var string
     */
    private $frontendScheme;

    /**
     * @var string
     */
    private $frontendDomain;

    public function __construct(MailerInterface $symfonyMailer, string $frontendScheme, string $frontendDomain)
    {
        $this->symfonyMailer = $symfonyMailer;
        $this->frontendScheme = $frontendScheme;
        $this->frontendDomain = $frontendDomain;
    }

    public function sendConfirmationEmail(ActionToken $actionToken)
    {
        $email = new TemplatedEmail();
        $email
            ->from('noreply@envstate.com')
            ->to($actionToken->getUser()->getEmail())
            ->subject('Confirm your email address')
            ->htmlTemplate('emails/registration_confirmation.html.twig')
            ->context([
                'frontendScheme' => $this->frontendScheme,
                'frontendDomain' => $this->frontendDomain,
                'actionToken' => $actionToken,
            ]);

        $this->symfonyMailer->send($email);
    }
}
