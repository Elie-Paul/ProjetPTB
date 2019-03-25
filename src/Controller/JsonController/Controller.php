<?php

namespace App\Controller\JsonController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Guichet;
use App\Entity\Trajet;
use App\Entity\Section;
use Symfony\Component\HttpFoundation\JsonResponse;


class Controller extends AbstractController
{
    /**
     * @Route("/json/controller/", name="json_controller_")
     */
    public function index()
    {
        
    }
     /**
     * @Route("/newCommande/", name="json_controller_")
     */
    public function newCommande(Request $request)
    {
        return new Response("<h1>".$request->getContent()."</h1>");
    }
    /**
     * @Route("/json/guichet/", name="json_controller_guichet")
     */
    public function getGuichet()
    {
        $repository = $this->getDoctrine()->getRepository(Guichet::class);
        $variable2 = $repository->findAll();
        $note = array();
        foreach ($variable2 as $key => $variable) 
        {
            $myarray = array('id' => "".$variable->getId()."",  'nom' => $variable->getNom());
            array_push($note,$myarray);
        }
        $data = [
            'notes' => $note];
            return new Response(json_encode($note));
    }
    /**
     * @Route("/json/section/", name="json_controller_section")
     */
    public function getSection()
    {
        $repository = $this->getDoctrine()->getRepository(Section::class);
        $variable2 = $repository->findAll();
        $note = array();
        foreach ($variable2 as $key => $variable) 
        {
            $myarray = array('id' => "".$variable->getId()."",  'libelle' => $variable->getLibelle());
            array_push($note,$myarray);
        }
        $data = [
            'notes' => $note];
            return new Response(json_encode($note));

    }
    /**
     * @Route("/json/trajet/{id}", name="json_controller_Trajet")
     */
    public function getTrajet($id)
    {
        $idGuichet=intval(explode('+',$id)[0]);
        $idSection=intval(explode('+',$id)[1]);
        $repository1 = $this->getDoctrine()->getRepository(Guichet::class);
        $repository2 = $this->getDoctrine()->getRepository(Section::class);
        //$repository = $this->getDoctrine()->getRepository(Trajet::class);
        $guichet = $repository1->find($idGuichet);
        $section = $repository2->find($idSection);
        $array   = $guichet->getBilletPtbs();
        $note = array();
        foreach ($array as $key => $variable) 
        {
            if ($variable->getPtb()->getSection() == $section) 
            {
                $myarray = array('id' => "".$variable->getId()."",  
                'Depart' => $variable->getPtb()->getTrajet()->getDepart()->getLibelle(),
                'Arrivee' => $variable->getPtb()->getTrajet()->getArrivee()->getLibelle());
                array_push($note,$myarray);  
            }
            
        }
        $data = [
            'notes' => $note];
            return new Response(json_encode($note));
    
    }
}

