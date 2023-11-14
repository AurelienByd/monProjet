<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class MailService
{
    //On injecte l'interface ParameterBag

    private $mailer;
    private $paramBag;

    public function __construct(ParameterBagInterface $paramBag, MailerInterface $mailer){

        $this->paramBag = $paramBag;
        $this->mailer = $mailer;

    }

    public function sendMail($expediteur, $destinataire, $sujet, $message){

    //On se sert du parameterBag et du nom du paramètre ('image_directory') pour récupèrer le chemin du dossier "images"
        $dossiers_images = $this->paramBag->get('images_directory');

        $email = (new Email())
            ->from($expediteur)
            ->to($destinataire)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($sujet)
            ->text($message)
            ->html('<h1>'.$sujet.'</h1><p>'.$message.'</p>');

        $this->mailer->send($email);
    
    }

}