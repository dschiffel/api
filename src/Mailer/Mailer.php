<?php declare(strict_types=1);

namespace App\Mailer;

use App\Entity\ActionToken;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{
    /**
     * @var MailerInterface
     */
    private $symfonyMailer;

    public function __construct(MailerInterface $symfonyMailer)
    {
        $this->symfonyMailer = $symfonyMailer;
    }

    public function sendConfirmationEmail(ActionToken $actionToken)
    {
        $email = new Email();
        $email
            ->from('noreply@envstate.com')
            ->to($actionToken->getUser()->getEmail())
            ->subject('Confirm your email address')
            ->html('<p>Please, confirm your email address</p>');

        $this->symfonyMailer->send($email);
    }
}
