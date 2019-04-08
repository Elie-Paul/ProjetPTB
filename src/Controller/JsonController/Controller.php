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
use App\Entity\Ptb;
use App\Entity\CommandePtb;
use App\Entity\StockPtb;
use App\Entity\VentePtb;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lieux;


class Controller extends AbstractController
{
    /**
     * @Route("/json/controller/", name="json_controller_")
     */
    public function index()
    {
        return $this->render('billet_taxe/index.html.twig', [
            'billet_taxes' => $billetTaxeRepository->findAll(),
        ]);
    }
    /**
     * @Route("/totalbillet/{id}", name="totalBillet")
     */
    public function totalBillet($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $billet = $entityManager->getRepository(BilletPtb::class)->find($id);
        $commnadesPTB = $entityManager->getRepository(CommandePtb::class)->findBy
        (
            [
                'billet' => $billet,
            ],
            ['dateCommande' =>'ASC']
        );
        $i=0;
        $nBillet=0;
        for ($i=0; $i < count($commnadesPTB); $i++) 
        { 
            if($commnadesPTB[$i]->getEtatCommande()>=1 || $commnadesPTB[$i]->getEtatCommande()==2)
            {
                $diff=$commnadesPTB[$i]->getNombreBillet()-$commnadesPTB[$i]->getNombreBilletRealise();
                $nBillet=$nBillet+$diff;
            }
        }
        return new response(''.$nBillet);
    }   
    
    /**
     * @Route("/commande/ptb", name="commande_ptb_index", methods={"GET"})
     */
    public function show()
    {
        return $this->render('commandeView/PTB/commandePTB.html.twig');
        //return new JsonResponse($commandePtbRepository->findAll());
        
    }
    /**
     * @Route("/commande/ptb/valider", name="commande_ptb_valider")
     */
    public function showAllCommandePTB()
    {
        return $this->render('commandeView/PTB/validerCommandePTB.html.twig');
    }
    /**
     * @Route("/commande/ptb/suivi", name="commande_ptb_suivi")
     */
    public function showAllCommandePTBSuivi()
    {
        return $this->render('commandeView/PTB/listCommandePTB.html.twig');
    }
    /**
     * @Route("/commande/ptb/vente", name="commande_ptb_vente")
     */
    public function showCommandePTBVente()
    {
        return $this->render('commandeView/PTB/venteCommandePTB.html.twig');
    }

     /**
     * @Route("/commande/ptb/imprimer", name="commande_ptb_imprimer")
     */
    public function showAllCommandePTBtoPrint()
    {
        return $this->render('commandeView/PTB/printCommandePTB.html.twig');
    } 
     /**
     * @Route("/Json/listCommande", name="getAllCommandePTB")
     */
    public function getAllCommandePTB()
    {
        $repository = $this->getDoctrine()->getRepository(CommandePtb::class);
        $commandePtbs = $repository->findBy(array(), array('dateCommande' => 'DESC'));;
        $data = array();
        foreach ($commandePtbs as $key => $variable) 
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
            return new Response(json_encode($data));
            //return new Response('dddd');
    }
    
     /**
     * @Route("/newCommande/", name="newCommande")
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
            ]
        );
        $commandePtb = new CommandePtb();
        $commandePtb->setBillet($billetPtb);
        $commandePtb->setNombreBillet(intval($array[3]));
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
     * @Route("/ValidationCommande", name="ValidationCommande")
     */
    public function ValidationCommande(Request $request)
    {
        $idCommande = intVal($request->getContent());
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        $commande = $entityManager
        ->getRepository(CommandePTB::class)
        ->find($idCommande);
        if($commande->getEtatCommande()==0)
            $commande->setEtatCommande(1);
        else
            $commande->setEtatCommande(0);
        $entityManager->flush();
        return new Response('<h1>'.$commande->getId().'</h1>');
    }

    /**
     * @Route("/addVentePTB/{id}/{nvente}", name="VentePtb")
     */
    public function VenteBillet($id,$nvente)
    {
        $idBillet = intVal($id);
        $vente = intVal($nvente);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        
        $billet = $entityManager
        ->getRepository(BilletPtb::class)
        ->find($idBillet);
        
        $ventePtb = new ventePtb();
        $ventePtb->setBillet($billet);
        $ventePtb->setCreateAt(new \DateTime());
        $ventePtb->setUpdatedAt(new \DateTime());
        $ventePtb->setNbreDeBillet($vente);
        $stockPtb=$entityManager->getRepository(StockPtb::class)->findOneBy([
            'billet' => $billet,
         ],);
        
        $stockPtb->setNbre($stockPtb->getNbre()- $vente);
        
        $entityManager->persist($ventePtb);
        $entityManager->flush();
        
        return new Response('<h1>'.$billet->getId().'</h1>');
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
     * @Route("/json/classe/", name="json_controller_classe")
     */
    public function getClasse()
    {
        $repository = $this->getDoctrine()->getRepository(Classe::class);
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
     * @Route("/json/TrajetBillet/", name="json_controller_TrajetBillet")
     */
    public function getTrajetBillet()
    {
        $repository = $this->getDoctrine()->getRepository(Trajet::class);
        $variable2 = $repository->findAll();
        $note = array();
        foreach ($variable2 as $key => $variable) 
        {
            $myarray = array('id' => "".$variable->getId()."",  
            'Depart' => $variable->getDepart()->getLibelle(),
            'Arrivee' => $variable->getArrivee()->getLibelle());
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
     * @Route("/json/lieu/depart", name="json_controller_lieu_depart")
     */
    public function getLieuxDepart()
    {
        $repository = $this->getDoctrine()->getRepository(Lieux::class);
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
     * @Route("/json/lieu/arrivee", name="json_controller_lieu_arrivee")
     */
    public function getLieuxArrivee()
    {
        $repository = $this->getDoctrine()->getRepository(Lieux::class);
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
     * @Route("/Json/ptb/billet", name="getAllbilletPTB")
     */
    public function getAllbilletPTB()
    {
        $billets = $this->getDoctrine()->getRepository(BilletPtb::class)->findAll();
        $data = array();
        foreach ($billets as $key => $billet) 
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
            return new Response(json_encode($data));
            //return new Response('dddd');
    }

    /**
     * @Route("/commande/ptb/modifier/{id}/{cmd}", name="commande_ptb_modifier")
     */
    public function modifierCommande($id,$cmd)
    {
        $id = intVal($id);
        $nbreCommande = intVal($cmd);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        
        $commandePtb = $entityManager
        ->getRepository(CommandePtb::class)
        ->find($id);
        
        $commandePtb->setNombreBillet($cmd);
        
        $entityManager->persist($commandePtb);
        $entityManager->flush();
        
        return new Response('<h1>ddddd</h1>');
    }
    
}

