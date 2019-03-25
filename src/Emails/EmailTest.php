<?php

namespace App\Emails;

use Twig\Environment;

class EmailTest
{

    /**
     * @var Envirenment
     */
    private $renderer;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify()
    {
        $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                ->setReplyTo('napalousmanadda@gmail.com')
                ->setBody('You should see me from the profiler!');
        
        $this->mailer->send($message);
    }

    
}



