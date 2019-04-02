<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DestinateurController extends AbstractController
{
    /**
     * @Route("/destinateur", name="destinateur")
     */
    public function index()
    {
        return $this->render('destinateur/index.html.twig', [
            'controller_name' => 'DestinateurController',
        ]);
    }
}
