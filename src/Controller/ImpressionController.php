<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImpressionController extends AbstractController
{
    /**
     * @Route("/impression", name="impression")
     */
    public function index()
    {
        return $this->render('impression/index.html.twig', [
            'controller_name' => 'ImpressionController',
        ]);
    }
}
