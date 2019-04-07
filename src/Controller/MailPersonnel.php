<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MailPersonnel extends AbstractController
{

    /**
     * @Route("/mail/presonnel", name="mail_personnel")
     * @param Request $request
     * @param MailController $envoi
     * @return JsonResponse
     */
    public function index(Request $request, MailController $envoi)
    {
        if($request->isXmlHttpRequest())
        {
            $emetteur = $_POST['emetteur'];
            $mails = $_POST['mails'];
            $email = null;
            $objet = $_POST['objet'];
            $message = $_POST['message'];
            if(count($mails) == 1)
            {
                $email = $mails[0];
                $envoi->mailPersonnel($emetteur, $email, $objet, $message);
                return new JsonResponse([
                    'status' => 'success',
                    'message' => "Votre message est envoyé avec succès à ".$email
                ]);
            }
        }
    }
}