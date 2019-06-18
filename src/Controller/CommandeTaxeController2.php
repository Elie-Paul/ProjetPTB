<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\BilletTaxe;
use App\Entity\StockTaxe;
use App\Entity\VenteTaxe;
use App\Entity\CommandeTaxe;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandeTaxeController2 extends AbstractController
{
    /**
     * @Route("/commande/taxe", name="commande_taxe")
     */
    public function index()
    {
        
        return $this->render('commandeView/taxe/CommandeTaxe.html.twig');
    }
    /**
     * @Route("/commande/taxe/valider", name="commande_taxe_valider")
     */
    public function showAllCommandeTaxeAValider()
    {
        return $this->render('commandeView/taxe/validerCommandeTaxe.html.twig');
    }
    /**
     * @Route("/commande/taxe/vente", name="commande_taxe_vente")
     */
    public function showCommandeTaxeVente()
    {
        return $this->render('commandeView/taxe/venteCommandeTaxe.html.twig');
    }
    /**
     * @Route("/commande/taxe/suivi", name="commande_taxe_suivi")
     */
    public function showAllCommandeTaxeSuivi()
    {
        return $this->render('commandeView/taxe/listCommandeTaxe.html.twig');
    }
    /**
     * @Route("/commande/taxe/imprimer", name="commande_taxe_imprimer")
     */
    public function showAllCommandeTaxeToPrint()
    {
        return $this->render('commandeView/taxe/printCommandeTaxe.html.twig');
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
        
        $commandeTaxe->setDateCommande($this->test35());
        
        $commandeTaxe->setCreatedAt($this->test35());
        $commandeTaxe->setUpdatedAt($this->test35());

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
                'Prix'=>$variable->getPrix(),
                'type' => $variable->getType()
            );
            array_push($data,$myarray);
        }
        return new Response(json_encode($data)); 
    }

    public function totalBillet2($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $billet = $entityManager->getRepository(BilletTaxe::class)->find($id);
        $commandeTaxe = $entityManager->getRepository(commandeTaxe::class)->findBy
        (
            [
                'billet' => $billet,
            ],
            ['dateCommande' =>'ASC']
        );
        $i=0;
        $nBillet=0;
        for ($i=0; $i < count($commandeTaxe); $i++) 
        { 
            if($commandeTaxe[$i]->getEtatCommande()>=1 || $commandeTaxe[$i]->getEtatCommande()==2)
            {
                $diff=$commandeTaxe[$i]->getNombreBillet()-$commandeTaxe[$i]->getNombreBilletRealise();
                $nBillet=$nBillet+$diff;
            }
        }
       return $nBillet;
    }
    
    /**
     * @Route("/Json/listCommandeTaxe", name="getAllCommandeTaxe")
     */
    public function getAllCommandeTaxe()
    {
        $repository = $this->getDoctrine()->getRepository(CommandeTaxe::class);
        $commandeTaxes = $repository->findBy(array(), array('dateCommande' => 'DESC'));
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
                
                'dateCommande' => $variable
                ->getDateCommande()
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
     * @Route("/addVenteTaxe/{id}/{nvente}", name="VenteTaxe")
     */
    public function VenteCommande($id,$nvente,MailController $mail)
    {
        
        $idBillet = intVal($id);
        $vente = intVal($nvente);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        
        $billet = $entityManager
        ->getRepository(BilletTaxe::class)
        ->find($idBillet);
        
        $venteTaxe = new venteTaxe();
        $venteTaxe->setBillet($billet);
        $venteTaxe->setCreateAt($this->test35());
        $venteTaxe->setUpdatedAt($this->test35());
        $venteTaxe->setNbreDeBillet($vente);
        $stockTaxe=$entityManager->getRepository(StockTaxe::class)->findOneBy([
            'billet' => $billet,
         ]);
        
        $stockTaxe->setNbre($stockTaxe->getNbre()- $vente);

        
        
        if($stockTaxe->getNbre() <=200)
        {
            $mail->sendMailForStock($billet->__toString());
        }
        
        $entityManager->persist($venteTaxe);
        $entityManager->flush();
        
        return new Response('<h1>'.$billet->getId().'</h1>');
    }
    /**
     * @Route("/addTaxeInvendu/{id}/{nvente}", name="VenteTaxeinvendu")
     */
    public function VenteCommandeInvendu($id,$nvente,MailController $mail)
    {

        $idBillet = intVal($id);
        $vente = intVal($nvente);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();

        $billet = $entityManager
        ->getRepository(BilletTaxe::class)
        ->find($idBillet);

//        $venteTaxe = new venteTaxe();
//        $venteTaxe->setBillet($billet);
//        $venteTaxe->setCreateAt($this->test35());
//        $venteTaxe->setUpdatedAt($this->test35());
//        $venteTaxe->setNbreDeBillet($vente);
        $stockTaxe=$entityManager->getRepository(StockTaxe::class)->findOneBy([
            'billet' => $billet,
         ]);

        $stockTaxe->setNbre($stockTaxe->getNbre()- $vente);


//        $entityManager->persist($venteTaxe);
        $entityManager->flush();

        return new Response('<h1>'.$billet->getId().'</h1>');
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
            if($commandesTaxe[$i]->getEtatCommande()>=1)
            {
                $diff=$commandesTaxe[$i]->getNombreBillet()-$commandesTaxe[$i]->getNombreBilletRealise();
                $nBillet=$nBillet+$diff;
            }
        }
        return new response(''.$nBillet);
    }
         /**
     * @Route("/Json/taxe/billet", name="getAllbilletTaxe")
     */
    public function getAllbilletTaxe()
    {
        $billets = $this->getDoctrine()->getRepository(BilletTaxe::class)->findAll();
        $data = array();
        foreach ($billets as $key => $billet) 
        {
            $stock = $this->getDoctrine()
            ->getRepository(StockTaxe::class)->findOneby(
                [
                    'billet' =>$billet,
                ]
            );
            $myarray = array
            (
               'id' => $billet->getId(),
                'guichet' =>'controlleur',
                'stock' => $stock->getNbre(),
                'prix' => $billet->getPrix()
            );
            array_push($data,$myarray);
        }
            return new Response(json_encode($data));
            //return new Response('dddd');
    }
    
    /**
     * @Route("/commande/taxe/modifier/{id}/{cmd}", name="commande_taxe_modifier")
     */
    public function modifierCommande($id,$cmd)
    {
        $id = intVal($id);
        $nbreCommande = intVal($cmd);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        
        $commandeTaxe = $entityManager
        ->getRepository(CommandeTaxe::class)
        ->find($id);
        
        $commandeTaxe->setNombreBillet($cmd);
        
        $entityManager->persist($commandeTaxe);
        $entityManager->flush();
        
        return new Response('<h1>ddddd</h1>');
    }
      /**
     * @Route("/commande/taxe/delete/{id}", name="commande_taxe_delete")
     */
    public function deleteCommande($id)
    {
        $id = intVal($id);
        
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        
        $commandeTaxe = $entityManager
        ->getRepository(CommandeTaxe::class)
        ->find($id);
        
        $entityManager->remove($commandeTaxe);
        $entityManager->flush();
        
        return new Response('<h1>ddddd</h1>');
    }
}
