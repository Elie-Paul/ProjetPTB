<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Guichet;
use App\Entity\Type;
use App\Entity\Trajet;
use App\Entity\Section;
use App\Entity\BilletPtb;
use App\Entity\Ptb;
use App\Entity\Vignette;
use App\Entity\CommandePtb;
use App\Entity\CommandeVignette;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lieux;

class CommandeVignetteController extends AbstractController
{
     /**
     * @Route("/commande/vignette", name="commande_vignette", methods={"GET"})
     */
    public function show()
    {
        return $this->render('commandeView/vignette/CommandeVignette.html.twig');
    }
    /**
     * @Route("/commande/vignette/valider", name="commande_vignette_valider")
     */
    public function showAllCommandeVignette()
    {
        return $this->render('commandeView/vignette/validerCommandeVignette.html.twig');
    }
    /**
     * @Route("/commande/vignette/suivi", name="commande_vignette_suivi")
     */
    public function showAllCommandeVignette2()
    {
        return $this->render('commandeView/vignette/listCommandeVignette.html.twig');
    }
    /**
     * @Route("/commande/vignette/imprimer", name="commande_vignette_imprimer")
     */
    public function showAllCommandeVignette3()
    {
        return $this->render('commandeView/vignette/printCommandeVignette.html.twig');
    }
    /**
     * @Route("/commande/vignette/vente", name="commande_vignette_vente")
     */
    public function showAllCommandeVignette4()
    {
        return $this->render('commandeView/vignette/venteCommandeVignette.html.twig');
    }
     /**
     * @Route("/Json/listCommandeVignette", name="getAllCommandeVignette")
     */
    public function getAllCommandeVignette()
    {
        $repository = $this->getDoctrine()->getRepository(CommandeVignette::class);
        $commandeVignettes = $repository->findBy(array(), array('dateCommande' => 'DESC'));;
        $data = array();
        foreach ($commandeVignettes as $key => $variable) 
        {
            $myarray = array
            (
                'id' => $variable->getId(),

                'section' => $variable
                ->getBillet()
                ->getType()
                ->getSection(),

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

                'type' => $variable
                ->getBillet()
                ->getType()
                ->getLibelle(),
                'dateCommande' => $variable
                ->getDateCommande()
            );
            array_push($data,$myarray);
        }
            return new Response(json_encode($data));
            //return new Response('dddd');
    }
    /**
     * @Route("/addVenteVignette/{id}/{nvente}", name="VenteVignette")
     */
    public function VenteCommande($id,$nvente)
    {
        $idCommande = intVal($id);
        $vente = intVal($nvente);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        $commande = $entityManager
        ->getRepository(CommandeVignette::class)
        ->find($idCommande);
        $commande->setNombreBilletVendu($commande->getNombreBilletVendu()+$vente);
        $entityManager->flush();
        return new Response('<h1>'.$commande->getId().'</h1>');
    }
     /**
     * @Route("/newCommandeVignette/", name="newCommandeVignette")
     */
    public function newCommandeVignette(Request $request)//Request $request
    {
        $array=explode('+',$request->getContent());//$request->getCOntent()
        $guichet = $this->getDoctrine()
        ->getRepository(Guichet::class)
        ->find(intval($array[0]));
        $type = $this->getDoctrine()
        ->getRepository(type::class)
        ->find(intval($array[1]));
        $vignette = $this->getDoctrine()
        ->getRepository(Vignette::class)
        ->findOneBy
        (
            [
                "guichet" => $guichet,
                "type" => $type,
            ]
        );
        $commandeVignette = new CommandeVignette();
        $commandeVignette->setBillet($vignette);
        $commandeVignette->setNombreBillet(intval($array[2]));
        $commandeVignette->setNombreBilletRealise(0);
        $commandeVignette->setNombreBilletVendu(0);
        
        $commandeVignette->setEtatCommande(0);
        
        $commandeVignette->setDateCommande(new \DateTime());
        //$commandeVignette->setDateCommandeValider(null);
        //$commandeVignette->setDateCommandeRealiser(null);
        
        $commandeVignette->setCreatedAt(new \DateTime());
        $commandeVignette->setUpdatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commandeVignette);
        $entityManager->flush();
        return new Response("true");
        //return new Response("<h1>".$ptb->getId()."</h1>");
    }
        /**
     * @Route("/ValidationCommandeVignette", name="ValidationCommandeVignette")
     */
    public function ValidationCommandeVignette(Request $request)
    {
        $idCommande = intVal($request->getContent());
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        $commande = $entityManager
        ->getRepository(CommandeVignette::class)
        ->find($idCommande);
        if($commande->getEtatCommande()==0)
            $commande->setEtatCommande(1);
        else
            $commande->setEtatCommande(0);
        $entityManager->flush();
        return new Response('<h1>'.$commande->getId().'</h1>');
    }
      /**
     * @Route("/json/type/", name="json_controller_type")
     */
    public function getType()
    {
        $repository = $this->getDoctrine()->getRepository(Type::class);
        $variable2 = $repository->findAll();
        $note = array();
        foreach ($variable2 as $key => $variable) 
        {
            $myarray = array('id' => "".$variable->getId()."",  'nom' => $variable->getLibelle()
        , 'section' => $variable->getSection());
            array_push($note,$myarray);
        }
        $data = [
            'notes' => $note];
            return new Response(json_encode($note));
    }
    /**
     * @Route("/totalbilletVignette/{id}", name="totalBilletVignette")
     */
    public function totalBillet($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $billet = $entityManager->getRepository(Vignette::class)->find($id);
        $commnadesVignette = $entityManager->getRepository(CommandeVignette::class)->findBy
        (
            [
                'billet' => $billet,
            ],
            ['dateCommande' =>'ASC']
        );
        $i=0;
        $nBillet=0;
        for ($i=0; $i < count($commnadesVignette); $i++) 
        { 
            if($commnadesVignette[$i]->getEtatCommande()==1 || $commnadesVignette[$i]->getEtatCommande()==2)
            {
                $diff=$commnadesVignette[$i]->getNombreBillet()-$commnadesVignette[$i]->getNombreBilletRealise();
                $nBillet=$nBillet+$diff;
            }
        }
        return new response(''.$nBillet);
    }   
}
