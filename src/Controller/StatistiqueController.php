<?php

namespace App\Controller;

use App\Entity\Ptb;
use App\Entity\Lieux;
use App\Entity\Trajet;
use App\Entity\Guichet;
use App\Entity\Section;
use App\Entity\Vignette;
use App\Entity\BilletPtb;
use App\Entity\BilletTaxe;
use App\Entity\CommandePtb;
use App\Entity\BilletNavette;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique/venteptb/guichet", name="statistique_venteptb_guichet")
     */
    public function index()
    {
        return $this->render('statistique/globalStat.html.twig', [
            'controller_name' => 'StatistiqueController',
        ]);
    }
    /**
     * @Route("/statistique/ventecommandeptb/guichet", name="statistique_ventecommandeptb_guichet")
     */
    public function index3()
    {
        return $this->render('statistique/index3.html.twig', [
            'controller_name' => 'StatistiqueController',
        ]);
    }
    /**
     * @Route("/statistique/commandeptb/guichet", name="statistique_commandeptb_guichet")
     */
    public function index2()
    {
        return $this->render('statistique/index2.html.twig', [
            'controller_name' => 'StatistiqueController',
        ]);
    }

    /**
     * @Route("/statistique/ventecommandeptb/billet", name="statistique_ventecommandeptb_billet")
     */
    public function index4()
    {
        return $this->render('statistique/index4.html.twig', [
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
         /**
     * @Route("/json/guichet2vente/", name="json_controller_guichet2vente")
     */
    public function getGuichet2()
    {
        $repository = $this->getDoctrine()->getRepository(Guichet::class);
        $guichets = $repository->findAll();
        $note = array();
        foreach ($guichets as $key => $guichet) 
        {
            $data2 = array();
            $ventes = array();
            foreach($guichet->getBilletPtbs() as $key => $billetP) 
            {
                
                foreach($billetP->getCommandePtbs() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nombreDeBilletCommander' => $variable->getNombreBillet(),
                        'nombreBilletRealiser' => $variable->getNombreBilletRealise(),
                        'nombreBilletVendu' => $variable->getNombreBilletVendu(),
                        'etat' => $variable->getEtatCommande(),
                        'dateCommandeValider' => $variable
                        ->getDateCommandeValider(),
                        'dateCommandeRealiser' => $variable
                        ->getDateCommandeRealiser(),
                        'dateCommande' => $variable
                        ->getDateCommande()
                    );
                    array_push($data2,$myarray);
                }
                foreach($billetP->getVentePtbs() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nbre' => $variable->getNbreDeBillet(),
                        'date' => $variable->getCreateAt(),
                    );
                    array_push($ventes,$myarray);
                }
            }
            $myarray = array(
              
                
                'guichet' => $guichet->getNom(),
                'commandes' => $data2,
                'ventes' => $ventes,
            );
            array_push($note,$myarray);
        }
            return new Response(json_encode($note));
    }
    /**
     * @Route("/json/billetPTBVente/", name="json_controller_billetPTBVente")
     */
    public function getbilletVente()
    {
        $repository = $this->getDoctrine()->getRepository(BilletPtb::class);
        $billetPtbs = $repository->findAll();
        $note = array();
        
            foreach($billetPtbs as $key => $billetP) 
            {
                $totalVente=0;
                foreach($billetP->getCommandePtbs() as $key => $commandeP) 
                {
                    $totalVente+=$commandeP->getNombreBilletVendu();
                }
                $myarray = array(
                    'label' => $billetP->getPtb()->__toString(),
                    'y' => $totalVente
                );
                array_push($note,$myarray);
            }
            
        
        $data = [
            'notes' => $note];
            return new Response(json_encode($note));
    }
    /**
     * @Route("/json/billet/ptb/Vente/", name="json/billet/ptb/Vente")
     */
    public function getbilletVente2()
    {
        $repository = $this->getDoctrine()->getRepository(BilletPtb::class);
        $repository1 = $this->getDoctrine()->getRepository(BilletNavette::class);
        $repository2 = $this->getDoctrine()->getRepository(Vignette::class);
        $repository3 = $this->getDoctrine()->getRepository(BilletTaxe::class);
        $billetPtbs = $repository->findAll();
        $billetNavetttes = $repository1->findAll();
        $Vignette = $repository2->findAll();
        $billetTaxes = $repository3->findAll();
        $note = array();
        
            foreach($billetPtbs as $key => $billetP) 
            {
                $commandes=array();
                $ventes=array();
                foreach($billetP->getCommandePtbs() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nombreDeBilletCommander' => $variable->getNombreBillet(),
                        
                        'nombreBilletRealiser' => $variable->getNombreBilletRealise(),
        
                        'nombreBilletVendu' => $variable->getNombreBilletVendu(),
        
                        'etat' => $variable->getEtatCommande(),
                        'dateCommandeValider' => $variable->getDateCommandeValider(),
                        'dateCommandeRealiser' => $variable->getDateCommandeRealiser(),
                        'dateCommande' => $variable->getDateCommande()
                    );
                    array_push($commandes,$myarray);
                }
                foreach($billetP->getVentePtbs() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nbre' => $variable->getNbreDeBillet(),
                        'date' => $variable->getCreateAt(),
                    );
                    array_push($ventes,$myarray);
                }
                $myarray = array(
                    'id' => $billetP->getId(),
                    'ptb' => $billetP->getPtb()->__toString(),
                    'commandes' => $commandes,
                    'guichet' => $billetP->getGuichet()->getCode(),
                    'ventes' => $ventes,
                );
                array_push($note,$myarray);
                
            }
            return new Response(json_encode($note));
    }
     /**
     * @Route("/json/statBillets/Vente/", name="json/statBillets/Vente")
     */
    public function getbilletVente3()
    {
        $repository = $this->getDoctrine()->getRepository(BilletPtb::class);
        $repository1 = $this->getDoctrine()->getRepository(BilletNavette::class);
        $repository2 = $this->getDoctrine()->getRepository(Vignette::class);
        $repository3 = $this->getDoctrine()->getRepository(BilletTaxe::class);
        $billetPtbs = $repository->findAll();
        $billetNavettes = $repository1->findAll();
        $Vignettes = $repository2->findAll();
        $billetTaxes = $repository3->findAll();
        $note = array();
        foreach($billetPtbs as $key => $billetP) 
        {
            $commandes=array();
            $ventes=array();
            foreach($billetP->getCommandePtbs() as $key => $variable) 
            {
                    $myarray = array
                    (
                        'nombreDeBilletCommander' => $variable->getNombreBillet(),
                        
                        'nombreBilletRealiser' => $variable->getNombreBilletRealise(),
        
                        'nombreBilletVendu' => $variable->getNombreBilletVendu(),
        
                        'etat' => $variable->getEtatCommande(),
                        'dateCommandeValider' => $variable->getDateCommandeValider(),
                        'dateCommandeRealiser' => $variable->getDateCommandeRealiser(),
                        'date' => $variable->getDateCommande()
                    );
                    array_push($commandes,$myarray);
            }
            foreach($billetP->getVentePtbs() as $key => $variable) 
            {
                    $myarray = array
                    (
                        'nbre' => $variable->getNbreDeBillet(),
                        'date' => $variable->getCreateAt(),
                    );
                    array_push($ventes,$myarray);
            }
                $myarray = array(
                    'id' => $billetP->getId(),
                    'type' => "PTB",
                    'billet' => $billetP->getPtb()->__toString(),
                    'commandes' => $commandes,
                    'guichet' => $billetP->getGuichet()->getCode(),
                    'ventes' => $ventes,
                );
                array_push($note,$myarray);
                
        }
            foreach($billetNavettes as $key => $billetNavette) 
            {
                $commandes=array();
                $ventes=array();
                foreach($billetNavette->getCommandeNavettes() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nombreDeBilletCommander' => $variable->getNombreBillet(),
                        
                        'nombreBilletRealiser' => $variable->getNombreBilletRealise(),
        
                        'nombreBilletVendu' => $variable->getNombreBilletVendu(),
        
                        'etat' => $variable->getEtatCommande(),
                        'dateCommandeValider' => $variable->getDateComnandeValider(),
                        'dateCommandeRealiser' => $variable->getDateCommandeRealiser(),
                        'date' => $variable->getDateCommande()
                    );
                    array_push($commandes,$myarray);
                }
                foreach($billetNavette->getVenteNavettes() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nbre' => $variable->getNbreDeBillet(),
                        'date' => $variable->getCreateAt(),
                    );
                    array_push($ventes,$myarray);
                }
                $myarray = array(
                    'id' => $billetNavette->getId(),
                    'type' =>'Autorail',
                    'billet' => $billetNavette->getNavette()->__toString(),
                    'commandes' => $commandes,
                    'guichet' => $billetNavette->getGuichet()->getCode(),
                    'ventes' => $ventes,
                );
                array_push($note,$myarray);
                
            }
            foreach($billetTaxes as $key => $billetTaxe) 
            {
                $commandes=array();
                $ventes=array();
                foreach($billetTaxe->getCommandeTaxes() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nombreDeBilletCommander' => $variable->getNombreBillet(),
                        
                        'nombreBilletRealiser' => $variable->getNombreBilletRealise(),
        
                        'nombreBilletVendu' => $variable->getNombreBilletVendu(),
        
                        'etat' => $variable->getEtatCommande(),
                        'dateCommandeValider' => $variable->getDateComnandeValider(),
                        'dateCommandeRealiser' => $variable->getDateCommandeRealiser(),
                        'date' => $variable->getDateCommande()
                    );
                    array_push($commandes,$myarray);
                }
                foreach($billetTaxe->getVenteTaxes() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nbre' => $variable->getNbreDeBillet(),
                        'date' => $variable->getCreateAt(),
                    );
                    array_push($ventes,$myarray);
                }
                $myarray = array(
                    'id' => $billetTaxe->getId(),
                    'type' => 'Taxe',
                    'billet' => $billetTaxe->__toString(),
                    'commandes' => $commandes,
                    'guichet' =>'CTRL',
                    'ventes' => $ventes,
                );
                array_push($note,$myarray);
                
            }
            foreach($Vignettes as $key => $vignette) 
            {
                $commandes=array();
                $ventes=array();
                foreach($vignette->getCommandeVignettes() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nombreDeBilletCommander' => $variable->getNombreBillet(),
                        
                        'nombreBilletRealiser' => $variable->getNombreBilletRealise(),
        
                        'nombreBilletVendu' => $variable->getNombreBilletVendu(),
        
                        'etat' => $variable->getEtatCommande(),
                        'dateCommandeValider' => $variable->getDateComnandeValider(),
                        'dateCommandeRealiser' => $variable->getDateCommandeRealiser(),
                        'date' => $variable->getDateCommande()
                    );
                    array_push($commandes,$myarray);
                }
                foreach($vignette->getVenteVignettes() as $key => $variable) 
                {
                    $myarray = array
                    (
                        'nbre' => $variable->getNbreDeBillet(),
                        'date' => $variable->getCreateAt(),
                    );
                    array_push($ventes,$myarray);
                }
                $myarray = array(
                    'id' => $vignette->getId(),
                    'type'=>'Vignette',
                    'billet' => $vignette->__toString(),
                    'commandes' => $commandes,
                    'guichet' => $billetP->getGuichet()->getCode(),
                    'ventes' => $ventes,
                );
                array_push($note,$myarray);
                
            }
            return new Response(json_encode($note));
    }
            
        
       
}

