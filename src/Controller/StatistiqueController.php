<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Guichet;
use App\Entity\Trajet;
use App\Entity\Section;
use App\Entity\BilletPtb;
use App\Entity\Ptb;
use App\Entity\CommandePtb;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lieux;


class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique", name="statistique")
     */
    public function index()
    {
        return $this->render('statistique/index.html.twig', [
            'controller_name' => 'StatistiqueController',
        ]);
    }
     /**
     * @Route("/json/guichetVente/", name="json_controller_guichetVente")
     */
    public function getGuichet()
    {
        $repository = $this->getDoctrine()->getRepository(Guichet::class);
        $variable2 = $repository->findAll();
        $note = array();
        foreach ($variable2 as $key => $variable) 
        {
            $totalVente=0;
            foreach($variable->getBilletPtbs() as $key => $billetP) 
            {
                foreach($billetP->getCommandePtbs() as $key => $commandeP) 
                {
                    $totalVente+=$commandeP->getNombreBilletVendu();
                }
            }
            $myarray = array(
              
                
                'label' => $variable->getNom(),
                'y' => $totalVente
            );
            array_push($note,$myarray);
        }
        $data = [
            'notes' => $note];
            return new Response(json_encode($note));
    }
}
