<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $replyTo;

    public function __construct(private MailerInterface $mailer,$replyTo)
    {   $this->replyTo = $replyTo;
        $to='achref.hjaiej@esprit.tn';
    }

    public function sendEmail(
        $to='achref.hjaiej@esprit.tn',
        $content='<p>See Twig integration for better HTML integration!</p>',
        $subject='Time for Symfony Mailer!'
        ): void
    {
        $email = (new Email())
            ->from('tessnime.Kabbous@esprit.tn')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text('Sending emails is fun again!')
            ->html($content);

           $this->mailer->send($email);
    }



}

