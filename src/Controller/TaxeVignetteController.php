<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\BilletTaxe;
use App\Entity\CommandeTaxe;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaxeVignetteController extends AbstractController
{
    /**
     * @Route("/commande/taxe", name="creationCommandeTaxe")
     */
    public function index1()
    {
        return $this->render('commandeView/CommandeTaxe.html.twig');
    }
    /**
     * @Route("/commande/vignette", name="creationCommandeVignette")
     */
    public function index2()
    {
        return $this->render('commandeView/CommandeVignette.html.twig');
    }
    /**
     * @Route("/newCommandeTaxe/", name="newCommandeTaxe")
     */
    public function newCommande(Request $request)//Request $request
    {
        $billetTaxe = $this->getDoctrine()->getRepository(BilletTaxe::class)->find(1);
        $commandeTaxe = new commandeTaxe();
        $commandeTaxe->setBillet($billetTaxe);
        $commandeTaxe->setNombreBillet(intVal($request->getContent()));
        $commandeTaxe->setNombreBilletRealise(0);
        $commandeTaxe->setNombreBilletVendu(0);
        
        $commandeTaxe->setEtatCommande(0);
        
        $commandeTaxe->setDateCommande(new \DateTime());
        
        $commandeTaxe->setCreatedAt(new \DateTime());
        $commandeTaxe->setUpdatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commandeTaxe);
        $entityManager->flush();
        return new Response("true");
        //return new Response("<h1>".$ptb->getId()."</h1>");
    }
    /**
     * @Route("json/BilletsTaxe/", name="jsonBilletTaxe")
     */
    public function getBilletsTaxe()
    {
        $billetTaxe = $this->getDoctrine()->getRepository(BilletTaxe::class)->findAll();
        $data = array();
        foreach ($billetTaxe as $key => $variable)
        {
            $myarray = array
            (
                'id'=>$variable->getId(),
                'Prix'=>$variable->getPrix()
            );
            array_push($data,$myarray);
        }
        return new Response(json_encode($data)); 
    }
    /**
     * @Route("/listCommandeTaxeToValid", name="showAllCommandeAValider")
     */
    public function showAllCommandeTaxeAValider()
    {
        return $this->render('commandeView/validerCommandeTaxe.html.twig');
    }
    /**
     * @Route("/listCommandeTaxeToPrint", name="showAllCommandeToPrint")
     */
    public function showAllCommandeTaxeToPrint()
    {
        return $this->render('commandeView/printCommandeTaxe.html.twig');
    }
    /**
     * @Route("/Json/listCommandeTaxe", name="getAllCommandeTaxe")
     */
    public function getAllCommandeTaxe()
    {
        $repository = $this->getDoctrine()->getRepository(CommandeTaxe::class);
        $commandeTaxes = $repository->findAll();
        $data = array();
        foreach ($commandeTaxes as $key => $variable) 
        {
            $myarray = array
            (
                'id' => $variable->getId(),

                'prix' => $variable
                ->getBillet()
                ->getPrix(),
                
                'guichet' => 'Controlleur',

                'nombreDeBilletCommander' => $variable
                ->getNombreBillet(),
                
                'nombreBilletRealiser' => $variable
                ->getNombreBilletRealise(),

                'nombreBilletVendu' => $variable
                ->getNombreBilletVendu(),

                'etat' => $variable
                ->getEtatCommande(),
                
                'dateCommandeValider' => $variable
                ->getDateComnandeValider()
            );
            array_push($data,$myarray);
        }
            return new Response(json_encode($data));
            //return new Response('dddd');
    }

    /**
     * @Route("/ValidationCommandeTaxe", name="ValidationCommandeTaxe")
     */
    public function ValidationCommande(Request $request)
    {
        $idCommande = intVal($request->getContent());
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        $commande = $entityManager
        ->getRepository(CommandeTaxe::class)
        ->find($idCommande);
        if($commande->getEtatCommande()==0)
            $commande->setEtatCommande(1);
        else
            $commande->setEtatCommande(0);
        $entityManager->flush();
        return new Response('<h1>'.$commande->getId().'</h1>');
    }
    /**
     * @Route("/totalbilletTaxe/{id}", name="totalBilletTaxe")
     */
    public function totalBillet($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $billet = $entityManager->getRepository(BilletTaxe::class)->find($id);
        $commandesTaxe = $entityManager->getRepository(commandeTaxe::class)->findBy
        (
            [
                'billet' => $billet,
            ],
            ['dateCommande' =>'ASC']
        );
        $i=0;
        $nBillet=0;
        for ($i=0; $i < count($commandesTaxe); $i++) 
        { 
            if($commandesTaxe[$i]->getEtatCommande()==1)
            {
                $diff=$commandesTaxe[$i]->getNombreBillet()-$commandesTaxe[$i]->getNombreBilletRealise();
                $nBillet=$nBillet+$diff;
            }
        }
        return new response(''.$nBillet);
    }
}
