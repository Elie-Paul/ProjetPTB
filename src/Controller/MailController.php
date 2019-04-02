<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Mailgun\Mailgun;
use Twig\Environment;

class MailController extends AbstractController
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $render;


    public function __construct(\Swift_Mailer $mailer, Environment $render)
    {
        $this->mailer = $mailer;
        $this->render = $render;
    }
    
    /**
     * @Route("/mail", name="mail")
     */
    public function index()
    {
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }

    public function sendMail($name)
    {
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('eliepaulmoubotouto@gmail.com')
        ->setTo('ddthera@gmail.com')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'mail/index.html.twig',
                ['name' => $name]
            ),
            'text/html'
        )
        ;

        $this->mailer->send($message);
    }

    /**
     * @param $username
     * @param $password
     * @param $nom
     * @param $prenom
     * @param $mail
     * @param $motif
     * Le motif permet de savoir dans twig si c'est un changement de mot de passe ou creation de user
     * @param $vue
     */
    public function sendMailToUser($username, $password, $nom, $prenom, $mail, $motif, $vue)
    {
        $message = (new \Swift_Message('Test mail par THERA pour Mr Ly'))
        ->setFrom('ddthera@gmail.com')
        ->setTo($mail)
        ->setBody(
            $this->renderView('mail/user.html.twig',[
                    'userNom' => $nom,
                    'userName' => $username,
                    'userPassword' => $password,
                    'userPrenom' => $prenom,
                    'motif' => $motif
                ]
            ),
            $vue
        )
        ;

        $this->mailer->send($message);
    }

    /**
     * @param $nom
     * @param $prenom
     * @param $typeBillet
     * @param $motif
     * Le motif permet de savoir dans twig si c'est un changement de mot de passe ou creation de user
     */
    public function sendMailForPrintBillet($nom, $prenom,$mail, $typeBillet, $motif, $vue)
    {
        $message = (new \Swift_Message('Test mail par THERA pour Mr Ly'))
        ->setFrom('ddthera@gmail.com')
        ->setTo($mail)
        ->setBody(
            $this->renderView('mail/user.html.twig',[
                    'userNom' => $nom,
                    'userPrenom' => $prenom,
                    'typeBillet' => $typeBillet,
                    'userPassword' => $motif,
                    'motif' => $motif
                ]
            ),
            $vue
        )
        ;

        $this->mailer->send($message);
    }

    /**
     * @param $nom
     * @param $prenom
     * @param $mail
     * @param $typeCommande
     * @param $motif
     * Le motif permet de savoir dans twig si c'est un changement de mot de passe ou creation de user
     */
    public function sendMailForCommande($nom, $prenom,$mail, $typeCommande, $motif, $vue)
    {
        $message = (new \Swift_Message('Test mail par THERA pour Mr Ly'))
        ->setFrom('ddthera@gmail.com')
        ->setTo($mail)
        ->setBody(
            $this->renderView('mail/user.html.twig',[
                    'userNom' => $nom,
                    'userPrenom' => $prenom,
                    'typeCommande' => $typeCommande,
                    'userPassword' => $motif,
                    'motif' => $motif
                ]
            ),
            $vue
        )
        ;

        $this->mailer->send($message);
    }
}
