<?php

namespace App\Controller\JsonController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Guichet;
use App\Entity\Classe;
use App\Entity\Trajet;
use App\Entity\Section;
use App\Entity\BilletPtb;
use App\Entity\User;
use App\Entity\Audit;
use App\Entity\TypeAudit;
use App\Entity\Ptb;
use App\Entity\Evenement;
use App\Entity\CommandePtb;
use App\Entity\StockPtb;
use App\Entity\VentePtb;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lieux;


class Controller2 extends AbstractController
{
    /**
     * @Route("/commande/event", name="commande_event_index", methods={"GET"})
     */
    public function show()
    {
        return $this->render('commandeView/event/commandePTB.html.twig');
        //return new JsonResponse($commandePtbRepository->findAll());
        
    }
    /**
     * @Route("/commande/event/valider", name="commande_event_valider")
     */
    public function showAllCommandeevent()
    {
        return $this->render('commandeView/event/validerCommandePTB.html.twig');
    }
    /**
     * @Route("/commande/event/suivi", name="commande_event_suivi")
     */
    public function showAllCommandePTBSuivi()
    {
        return $this->render('commandeView/event/listCommandePTB.html.twig');
    }
    /**
     * @Route("/commande/event/vente", name="commande_event_vente")
     */
    public function showCommandePTBVente()
    {
        return $this->render('commandeView/event/venteCommandePTB.html.twig');
    }

    /**
     * @Route("/commande/event/retour", name="commande_event_retour")
     */
    public function showCommandePTBRetour()
    {
        return $this->render('commandeView/event/venteCommandePTB2.html.twig');
    }

     /**
     * @Route("/commande/event/imprimer", name="commande_event_imprimer")
     */
    public function showAllCommandePTBtoPrint()
    {
        return $this->render('commandeView/event/printCommandePTB.html.twig');
    } 
      /**
     * @Route("/Json/listCommande/event", name="getAllCommandeEvent")
     */
    public function getAllCommandePTB()
    {
        $repository = $this->getDoctrine()->getRepository(CommandePtb::class);
        $commandePtbs = $repository->findBy(array(), array('dateCommande' => 'DESC'));;
        $data = array();
        foreach ($commandePtbs as $key => $variable) 
        {
            if($variable->getBillet()->getEvenement() != null)
            {
                $myarray = array
                (
                    'id' => $variable->getId(),

                    'section' => $variable
                    ->getBillet()
                    ->getPtb()
                    ->getSection(),

                    'depart' => $variable
                    ->getBillet()
                    ->getPtb()->getTrajet()
                    ->getDepart()
                    ->getLibelle(),

                    'arrivee' => $variable
                    ->getBillet()
                    ->getPtb()->getTrajet()
                    ->getArrivee()
                    ->getLibelle(),

                    'guichet' => $variable
                    ->getBillet()
                    ->getGuichet()
                    ->getNom(),

                    'nombreDeBilletCommander' => $variable
                    ->getNombreBillet(),
                    
                    'nombreBilletRealiser' => $variable
                    ->getNombreBilletRealise(),

                    'nombreBilletVendu' => $variable
                    ->getNombreBilletVendu(),

                    'etat' => $variable
                    ->getEtatCommande(),
                    'event' => $variable->getBillet()->getEvenement()->getLibelle(),
                    'section' => $variable
                    ->getBillet()
                    ->getPtb()
                    ->getSection()
                    ->getLibelle(),
                    'dateCommandeValider' => $variable
                    ->getDateCommandeValider(),
                    'dateCommandeRealiser' => $variable
                    ->getDateCommandeRealiser(),
                    'dateCommande' => $variable
                    ->getDateCommande()
                );
                array_push($data,$myarray);
            }    
        }
            return new Response(json_encode($data));
            //return new Response('dddd');
    }
    
   

   
     /**
     * @Route("/json/event/", name="json_controller_event")
     */
    public function getEvent()
    {
        $repository = $this->getDoctrine()->getRepository(Evenement::class);
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
     * @Route("/json/trajetEvent/{id}", name="json_controller_Trajet")
     */
    public function getTrajet($id)
    {
        $idGuichet=intval(explode('+',$id)[0]);
        $idSection=intval(explode('+',$id)[1]);
        $idEvent=intval(explode('+',$id)[2]);
        $repository1 = $this->getDoctrine()->getRepository(Guichet::class);
        $repository2 = $this->getDoctrine()->getRepository(Section::class);
        $repository3 = $this->getDoctrine()->getRepository(Evenement::class);
        //$repository = $this->getDoctrine()->getRepository(Trajet::class);
        $guichet = $repository1->find($idGuichet);
        $section = $repository2->find($idSection);
        $event = $repository3->find($idEvent);
        $array   = $guichet->getBilletPtbs();
        $note = array();
        foreach ($array as $key => $variable) 
        {
            
            if ($variable->getPtb()->getSection() == $section && $variable->getEvenement() == $event ) 
            {
                $myarray = array('id' => "".$variable->getPtb()->getTrajet()->getId(),  
                'Depart' => $variable->getPtb()->getTrajet()->getDepart()->getLibelle(),
                'Arrivee' => $variable->getPtb()->getTrajet()->getArrivee()->getLibelle());
                array_push($note,$myarray);  
            }
            
        }
        $data = [
            'notes' => $note];
            return new Response(json_encode($note));
    
    }

   /**
     * @Route("/newCommande/Event", name="newCommande")
     */
    public function newCommande(Request $request)//Request $request
    {
        $array=explode('+',$request->getCOntent());//
        $guichet = $this->getDoctrine()
        ->getRepository(Guichet::class)
        ->find(intval($array[0]));
        $section = $this->getDoctrine()
        ->getRepository(Section::class)
        ->find(intval($array[1]));
        $trajet = $this->getDoctrine()
        ->getRepository(Trajet::class)
        ->find(intval($array[2]));

        $event = $this->getDoctrine()
        ->getRepository(Evenement::class)
        ->find(intval($array[3]));
        $ptb = $this->getDoctrine()
        ->getRepository(Ptb::class)
        ->findOneBy
        (
            [
                "trajet" => $trajet,
                "section" => $section
            ]
        );
        $billetPtb = $this->getDoctrine()
        ->getRepository(BilletPtb::class)
        ->findOneBy
        (
            [
                "guichet" => $guichet,
                "ptb" => $ptb,
                "evenement" => $event
            ]
        );
        $commandePtb = new CommandePtb();
        $commandePtb->setBillet($billetPtb);
        $commandePtb->setNombreBillet(intval($array[4]));
        $commandePtb->setNombreBilletRealise(0);
        $commandePtb->setNombreBilletVendu(0);
        
        $commandePtb->setEtatCommande(0);
        
        $commandePtb->setDateCommande(new \DateTime());
        //$commandePtb->setDateCommandeValider(null);
        //$commandePtb->setDateCommandeRealiser(null);
        
        $commandePtb->setCreatedAt(new \DateTime());
        $commandePtb->setUpdatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commandePtb);
        $entityManager->flush();
        return new Response("true");
        //return new Response("<h1>".$ptb->getId()."</h1>");
    }
    /**
     * @Route("/Json/event/billet", name="getAllbilletEvent")
     */
    public function getAllbilletPTB()
    {
        $billets = $this->getDoctrine()->getRepository(BilletPtb::class)->findAll();
        $data = array();
        foreach ($billets as $key => $billet) 
        {
            if($billet->getEvenement() != null)
            {
                $stock = $this->getDoctrine()
                ->getRepository(StockPtb::class)->findOneby(
                    [
                        'billet' =>$billet,
                    ]
                );
                $myarray = array
                (
                    'id' => $billet->getId(),

                    'section' => $billet
                    ->getPtb()
                    ->getSection()
                    ->getLibelle(),
                    'event' => $billet
                    ->getEvenement()->getLibelle(),
                    'depart' => $billet
                    ->getPtb()
                    ->getTrajet()
                    ->getDepart()
                    ->getLibelle(),

                    'arrivee' => $billet
                    ->getPtb()
                    ->getTrajet()
                    ->getArrivee()
                    ->getLibelle(),

                    'guichet' =>$billet
                    ->getGuichet()
                    ->getNom(),
                    'stock' => $stock->getNbre(),
                );
                array_push($data,$myarray);
            }
        }
            return new Response(json_encode($data));
            //return new Response('dddd');
    }
}

