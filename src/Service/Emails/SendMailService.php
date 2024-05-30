<?php

namespace App\Service\Emails;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMailService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @param array<string, string> $context
     *
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function send(
        string $from,
        string $to,
        string $subject,
        array $context,
        string $template
    ): void {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate(sprintf('layouts/emails/%s.html.twig', $template))
            ->context($context);
        $this->mailer->send($email);
    }
}
