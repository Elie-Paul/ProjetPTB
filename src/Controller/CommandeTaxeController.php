<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\BilletTaxe;
use App\Entity\StockTaxe;
use App\Entity\VenteTaxe;
use App\Entity\User;
use App\Entity\Audit;
use App\Entity\TypeAudit;
use App\Entity\CommandeTaxe;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandeTaxeController extends AbstractController
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
            if($commandeTaxe[$i]->getEtatCommande()>=1 && $commandeTaxe[$i]->getEtatCommande()<=2)
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
    public function VenteCommande($id,$nvente)
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
        $venteTaxe->setCreateAt(new \DateTime());
        $venteTaxe->setUpdatedAt(new \DateTime());
        $venteTaxe->setNbreDeBillet($vente);
        $stockTaxe=$entityManager->getRepository(StockTaxe::class)->findOneBy([
            'billet' => $billet,
         ],);
        
        $stockTaxe->setNbre($stockTaxe->getNbre()- $vente);
        
        $entityManager->persist($venteTaxe);
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
            if($commandesTaxe[$i]->getEtatCommande()>=1 && $commandesTaxe[$i]->getEtatCommande()<=2)
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
    /**
     * @Route("/returnVenteTaxe/{id}/{nvente}/{idUser}", name="returnTaxe")
     */
    public function RetourBillet($id,$nvente,$idUser)
    {
        $idBillet = intVal($id);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        $vente = intVal($nvente);
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval(1));
        $billet = $entityManager
        ->getRepository(BilletTaxe::class)
        ->find($idBillet);
        
        $stockPtb=$entityManager->getRepository(StockTaxe::class)->findOneBy([
            'billet' => $billet,
         ]);
        
        if($vente == $stockPtb->getNbre())
        {
            $type = $this->getDoctrine()
            ->getRepository(TypeAudit::class)
            ->find(intval(3));
            $audit = new Audit();
            $audit->setUser($user);
            $audit->setType($type);
            $text = "le guichet ".$billet->getGuichet()." à retourné ".$vente." billet ". $billet->getPtb()." comme prevus";
            $audit->setDescription($text);
            $audit->setCreatedAt(new \DateTime());
            $audit->setUpdatedAt(new \DateTime());
            $entityManager->persist($audit);
        }
        else
        {
            $type = $this->getDoctrine()
            ->getRepository(TypeAudit::class)
            ->find(intval(4));
            $audit = new Audit();
            $audit->setUser($user);
            $audit->setType($type);
            $text = "le guichet ".$billet->getGuichet()."à retourné ".$vente." billet ". $billet->getPtb()." alors qu'il devait retourné".$stockPtb->getNbre();
            $audit->setDescription($text);
            $audit->setCreatedAt(new \DateTime());
            $audit->setUpdatedAt(new \DateTime());
            $entityManager->persist($audit);
        }
        
        
        $entityManager->flush();
        
        return new Response('<h1>'.$billet->getId().'</h1>');
    }
}
