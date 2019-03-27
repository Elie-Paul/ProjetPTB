<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Guichet;
use App\Entity\Trajet;
use App\Entity\Classe;
use App\Entity\BilletNavette;
use App\Entity\Navette;
use App\Entity\CommandeNavette;
use Symfony\Component\HttpFoundation\JsonResponse;

class ControllerCommandeNavetteController extends AbstractController
{
    /**
     * @Route("/commande/navette", name="controller_commande_navette")
     */
    public function index()
    {
        return $this->render('commandeView/CommandeNavette.html.twig');
    }
    /**
     * @Route("/totalbilletNavette/{id}", name="totalBilletNavette")
     */
    public function totalBillet($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $billet = $entityManager->getRepository(BilletNavette::class)->find($id);
        $commnadesNavette = $entityManager->getRepository(CommandeNavette::class)->findBy
        (
            [
                'billet' => $billet,
            ],
            ['dateCommande' =>'ASC']
        );
        $i=0;
        $nBillet=0;
        for ($i=0; $i < count($commnadesNavette); $i++) 
        { 
            if($commnadesNavette[$i]->getEtatCommande()==1)
            {
                $diff=$commnadesNavette[$i]->getNombreBillet()-$commnadesNavette[$i]->getNombreBilletRealise();
                $nBillet=$nBillet+$diff;
            }
        }
        return new response(''.$nBillet);
    }    
    /**
     * @Route("/listCommandeNavette", name="showAllCommandeNavette")
     */
    public function showAllCommandeNavette()
    {
        return $this->render('commandeView/validerCommandeNavette.html.twig');
    }
     /**
     * @Route("/Json/listCommandeNavette", name="getAllCommandeNavette")
     */
    public function getAllCommandeNavette()
    {
        $repository = $this->getDoctrine()->getRepository(CommandeNavette::class);
        $commandeNavettes = $repository->findAll();
        $data = array();
        foreach ($commandeNavettes as $key => $variable) 
        {
            $myarray = array
            (
                'id' => $variable->getId(),

                'classe' => $variable
                ->getBillet()
                ->getNavette()
                ->getClasse(),

                'depart' => $variable
                ->getBillet()
                ->getNavette()->getTrajet()
                ->getDepart()
                ->getLibelle(),

                'arrivee' => $variable
                ->getBillet()
                ->getNavette()->getTrajet()
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

                'classe' => $variable
                ->getBillet()
                ->getNavette()
                ->getClasse()
                ->getLibelle(),
                'dateCommandeValider' => $variable
                ->getDateComnandeValider()
            );
            array_push($data,$myarray);
        }
            return new Response(json_encode($data));
            //return new Response('dddd');
    }
     /**
     * @Route("/listCommandeNavettetoPrint", name="showAllCommandeNavettetoPrint")
     */
    public function showAllCommandeNavettetoPrint()
    {
        return $this->render('commandeView/printCommandeNavette.html.twig');
    }
     /**
     * @Route("/newCommandeNavette/", name="newCommandeNavette")
     */
    public function newCommande(Request $request)//Request $request
    {
        $array=explode('+',$request->getCOntent());//
        $guichet = $this->getDoctrine()
        ->getRepository(Guichet::class)
        ->find(intval($array[0]));
        $classe = $this->getDoctrine()
        ->getRepository(Classe::class)
        ->find(intval($array[1]));
        $trajet = $this->getDoctrine()
        ->getRepository(Trajet::class)
        ->find(intval($array[2]));
        $navette = $this->getDoctrine()
        ->getRepository(Navette::class)
        ->findOneBy
        (
            [
                "trajet" => $trajet,
                "classe" => $classe
            ]
        );
        $billetNavette = $this->getDoctrine()
        ->getRepository(BilletNavette::class)
        ->findOneBy
        (
            [
                "guichet" => $guichet,
                "navette" => $navette,
            ]
        );
        $commandeNavette = new CommandeNavette();
        $commandeNavette->setBillet($billetNavette);
        $commandeNavette->setNombreBillet(intval($array[3]));
        $commandeNavette->setNombreBilletRealise(0);
        $commandeNavette->setNombreBilletVendu(0);
        
        $commandeNavette->setEtatCommande(0);
        
        $commandeNavette->setDateCommande(new \DateTime());
        
        $commandeNavette->setCreatedAt(new \DateTime());
        $commandeNavette->setUpdatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commandeNavette);
        $entityManager->flush();
        return new Response("true");
        //return new Response("<h1>".$ptb->getId()."</h1>");
    }
    /**
     * @Route("/ValidationCommandeNavette", name="ValidationCommandeNavette")
     */
    public function ValidationCommande(Request $request)
    {
        $idCommande = intVal($request->getContent());
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        $commande = $entityManager
        ->getRepository(CommandeNavette::class)
        ->find($idCommande);
        if($commande->getEtatCommande()==0)
            $commande->setEtatCommande(1);
        else
            $commande->setEtatCommande(0);
        $entityManager->flush();
        return new Response('<h1>'.$commande->getId().'</h1>');
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
     * @Route("/json/trajetNavette/{id}", name="json_controller_Trajet_Navette")
     */
    public function getTrajet($id)
    {
        $idGuichet=intval(explode('+',$id)[0]);
        $idClasse=intval(explode('+',$id)[1]);
        $repository1 = $this->getDoctrine()->getRepository(Guichet::class);
        $repository2 = $this->getDoctrine()->getRepository(Classe::class);
        //$repository = $this->getDoctrine()->getRepository(Trajet::class);
        $guichet = $repository1->find($idGuichet);
        $classe = $repository2->find($idClasse);
        $array   = $guichet->getBilletNavettes();
        $note = array();
        foreach ($array as $key => $variable) 
        {
            if ($variable->getNavette()->getClasse() == $classe) 
            {
                $myarray = array('id' => "".$variable->getNavette()->getTrajet()->getId(),  
                'Depart' => $variable->getNavette()->getTrajet()->getDepart()->getLibelle(),
                'Arrivee' => $variable->getNavette()->getTrajet()->getArrivee()->getLibelle());
                array_push($note,$myarray);  
            }
            
        }
        $data = [
            'notes' => $note];
            return new Response(json_encode($note));
    
    }

}