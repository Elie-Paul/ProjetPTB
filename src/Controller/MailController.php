<?php

namespace App\Controller;

use App\Entity\Destinateur;
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

    /**
     * @Route("/mail/print", name="mail_print")
     */
    public function mailPrint()
    {
        return $this->render('mail/mailprint.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }

    /**
     * @Route("/dfmail", name="df_mail")
     */
    public function indexDF()
    {
        return $this->render('mail/dafmail.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }

    public function sendMail($name)
    {
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('eliepaulmoubotouto@gmail.com')
        ->setTo('theradaouda@yahoo.com')
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

//    ENVOI DE MAIL PRIVEE DEPUIS LE DASHBOARD

    /**
     * @param $emetteur
     * @param $destinateur
     * @param $objet
     * @param $message
     */
    public function mailPersonnel($emetteur ,$destinateur, $objet, $message)
    {
        $message = (new \Swift_Message($objet))
            ->setFrom('ptbsaptb@gmail.com')
            ->setTo($destinateur)
            ->setBody(
                $this->renderView('mail/personnel.html.twig',[
                        'emetteur' => $emetteur,
                        'destinateur' => $destinateur,
                        'objet' => $objet,
                        'message' => $message
                    ]
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
     * @param $vue
     */
    public function sendMailToUser($username, $password, $nom, $prenom, $mail, $role, $vue)
    {
        $message = (new \Swift_Message('Bonjour, PTB vous souhaite une bonne journée'))
        ->setFrom('ptbsaptb@gmail.com')
        ->setTo($mail)
        ->setBody(
//            $this->renderView('mail/user.html.twig',[
//                    'userNomptbsaptb@gmail.com' => $nom,
//                    'userName' => $username,
//                    'userPassword' => $password,
//                    'userPrenom' => $prenom
//                ]
            $this->renderView($vue,[
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'username' => $username,
                    'password' => $password,
                    'mail' => $mail,
                    'role' => $role,
                ]
            ),
            'text/html'
        )
        ;

        $this->mailer->send($message);
    }

    /**
     * @param $depart
     * @param $arrive
     * @param $vue
     */
    public function sendMailForPrint($depart, $arrive)
    {
        $destinateur = $this->getDoctrine()->getRepository(Destinateur::class)->findBy([
            'processus' => 'impression'
        ]);
        if($destinateur)
        {
            foreach ($destinateur as $dest)
            {
                $message = (new \Swift_Message('Bonjour, PTB vous souhaite une bonne journée'))
                    ->setFrom('ddthera@gmail.com')
                    ->setTo($dest->getEmail())
                    ->setBody(
                        $this->renderView('mail/mailprint.html.twig', [
//                                'nom' => $nom,
//                                'prenom' => $prenom,
//                                'mail' => $mail,
//                                'role' => $role,
                                'depart' => $depart,
                                'arrivee' => $arrive,
                            ]
                        ),
                        'text/html'
                    );

                $this->mailer->send($message);
            }
        }

    }

    public function sendMailForCommande($nom, $prenom, $email, $vue)
    {
        $destinateur = $this->getDoctrine()->getRepository(Destinateur::class)->findBy([
            'processus' => 'commande'
        ]);
        if($destinateur)
        {
            foreach ($destinateur as $dest)
            {
                $message = (new \Swift_Message('Test mail par THERA pour Mr Ly'))
                    ->setFrom('ddthera@gmail.com')
                    ->setTo($dest->getEmail())
                    ->setBody(
                        $this->renderView($vue, [
                            'Nom' => $nom,
                            'Prenom' => $prenom,
                            'Email' => $email
                        ]),
                        'text/html'
                    );

                $this->mailer->send($message);
            }
        }
    }
}
