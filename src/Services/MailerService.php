<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;



class MailerService
{
    public function __construct(private MailerInterface $mailer){}
    public function sendEmail(
        $to = 'youssef.regui@esprit.tn',
        $content = '<p>See Twig integration for better HTML integration!</p>',
        $subjet ='Time for Symfony Mailer!'
    ): void
    {
        $email = (new Email())
            ->from('youssef.regui@esprit.tn')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subjet)
            //->text('Sending emails is fun again!')
            ->html($content);

        $this->mailer->send($email);

        // ...
    }
}