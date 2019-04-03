<?php

namespace App\Controller;

use App\Entity\Destinateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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
     * @param $vue
     */
    public function sendMailToUser($username, $password, $nom, $prenom, $mail, $vue)
    {
        $message = (new \Swift_Message('Test mail par THERA pour Mr Ly'))
        ->setFrom('ddthera@gmail.com')
        ->setTo($mail)
        ->setBody(
//            $this->renderView('mail/user.html.twig',[
//                    'userNom' => $nom,
//                    'userName' => $username,
//                    'userPassword' => $password,
//                    'userPrenom' => $prenom
//                ]
            $this->renderView($vue,[
                    'userNom' => $nom,
                    'userName' => $username,
                    'userPassword' => $password,
                    'userPrenom' => $prenom
                ]
            ),
            'text/html'
        )
        ;

        $this->mailer->send($message);
    }

    public function sendMailUserInfo($nom, $prenom, $mailUser, $vue)
    {
        $destinateur = $this->getDoctrine()->getRepository(Destinateur::class)->findBy([
            'processus' => 'utilisateur'
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
                                'userNom' => $nom,
                                'userPrenom' => $prenom,
                                'userMail' => $mailUser
                            ]
                        ),
                        'text/html'
                    );

                $this->mailer->send($message);
            }
        }
    }

    /**
     * @param $nom
     * @param $prenom
     * @param $mail
     * @param $typeBillet
     * @param $mailDestinateur
     * @param $vue
     */
    public function sendMailForPrint($nom, $prenom,$mail, $typeBillet, $vue)
    {
        $destinateur = $this->getDoctrine()->getRepository(Destinateur::class)->findBy([
            'processus' => 'impression'
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
                                'userNom' => $nom,
                                'userPrenom' => $prenom,
                                'userPassword' => $mail,
                                'typeBillet' => $typeBillet
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
                            'Prenom' => $prenom
                        ]),
                        'text/html'
                    );

                $this->mailer->send($message);
            }
        }
    }
}
