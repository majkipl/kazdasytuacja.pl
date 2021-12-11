<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TripFormMailer
{
    /**
     * @param MailerInterface $mailer
     * @param Environment $twig
     */
    public function __construct(private MailerInterface $mailer, private Environment $twig) {}

    /**
     * @param array $formData
     * @return void
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendEmail(array $formData)
    {
        $plain = $this->twig->render('email/plain/trip.html.twig');

        $email = (new TemplatedEmail())
            ->from($_ENV['MAIL_SENDER_EMAIL'])
            ->to($formData['email'])
            ->subject('Kazdasytuacja.pl : Dziękujemy za potwierdzenie zgłoszenia.')
            ->text($plain)
            ->htmlTemplate('email/html/trip.html.twig');

        $this->mailer->send($email);
    }
}