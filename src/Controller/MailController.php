<?php

namespace App\Controller;

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
        ->setTo('eliemoubotouto@outlook.fr')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'mail/index.html.twig',
                ['name' => $name]
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    ['name' => $name]
                ),
                'text/plain'
            )
            */
        ;

        $this->mailer->send($message);
    }

    /**
     * @Route("/mail/test", name="mail_test")
     */
    public function send()
    {
        # First, instantiate the SDK with your API credentials
        $mg = Mailgun::create('33ebd2ea7a189e527451398addbeeb41-e51d0a44-3d8c767e');

        # Now, compose and send your message.
        # $mg->messages()->send($domain, $params);
        $mg->messages()->send('sandboxa46864eaa2604719b5503ccec7e9aa61.mailgun.org', [
        'from'    => 'ReadTodev <eliepaulmoubotouto@gmail.com>',
        'to'      => 'ReadTodev <eliepaulmoubotouto@gmail.com>',
        'subject' => 'Hello',
        'text'    => 'Testing some Mailgun awesomness!'
        ]);

        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
}
