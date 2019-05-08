<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\MailController;
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
use App\Entity\StockVignette;
use App\Entity\VenteVignette;
use App\Entity\CommandePtb;
use App\Entity\CommandeVignette;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lieux;

class CommandeVignetteController2 extends AbstractController
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

    public function totalBillet2($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $billet = $entityManager->getRepository(Vignette::class)->find($id);
        $commandeVignettes = $entityManager->getRepository(CommandeVignette::class)->findBy
        (
            [
                'billet' => $billet,
            ],
            ['dateCommande' =>'ASC']
        );
        $i=0;
        $nBillet=0;
        for ($i=0; $i < count($commandeVignettes); $i++) 
        { 
            if($commandeVignettes[$i]->getEtatCommande()>=1 || $commandeVignettes[$i]->getEtatCommande()==2)
            {
                $diff=$commandeVignettes[$i]->getNombreBillet()-$commandeVignettes[$i]->getNombreBilletRealise();
                $nBillet=$nBillet+$diff;
            }
        }
       return $nBillet;
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
    public function VenteCommande($id,$nvente,MailController $mail)
    {
        $idBillet = intVal($id);
        $vente = intVal($nvente);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        
        $billet = $entityManager
        ->getRepository(Vignette::class)
        ->find($idBillet);
        
        $venteVignette = new venteVignette();
        $venteVignette->setBillet($billet);
        $venteVignette->setCreateAt(new \DateTime());
        $venteVignette->setUpdatedAt(new \DateTime());
        $venteVignette->setNbreDeBillet($vente);
        $stockVignette=$entityManager->getRepository(StockVignette::class)->findOneBy([
            'billet' => $billet,
         ]);
        
        $stockVignette->setNbre($stockVignette->getNbre()- $vente);

        
        
        if($stockVignette->getNbre() <=200)
        {
            $mail->sendMailForStock($billet->__toString());
        }
        
        $entityManager->persist($venteVignette);
        $entityManager->flush();
        
        return new Response('<h1>'.$billet->getId().'</h1>');
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
            if($commnadesVignette[$i]->getEtatCommande()>=1 || $commnadesVignette[$i]->getEtatCommande()==2)
            {
                $diff=$commnadesVignette[$i]->getNombreBillet()-$commnadesVignette[$i]->getNombreBilletRealise();
                $nBillet=$nBillet+$diff;
            }
        }
        return new response(''.$nBillet);
    }
     /**
     * @Route("/Json/vignette/billet", name="getAllbilletVignette")
     */
    public function getAllbilletVignette()
    {
        $billets = $this->getDoctrine()->getRepository(Vignette::class)->findAll();
        $data = array();
        foreach ($billets as $key => $billet) 
        {
            $stock = $this->getDoctrine()
            ->getRepository(StockVignette::class)->findOneby(
                [
                    'billet' =>$billet,
                ]
            );
            $myarray = array
            (
               'id' => $billet->getId(),

                'section' => $billet
                ->getType()
                ->getSection(),
                'type' => $billet
                ->getType()
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
     * @Route("/commande/vignette/modifier/{id}/{cmd}", name="commande_vignette_modifier")
     */
    public function modifierCommande($id,$cmd)
    {
        $id = intVal($id);
        $nbreCommande = intVal($cmd);
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        
        $commandeVignette = $entityManager
        ->getRepository(CommandeVignette::class)
        ->find($id);
        
        $commandeVignette->setNombreBillet($cmd);
        
        $entityManager->persist($commandeVignette);
        $entityManager->flush();
        
        return new Response('<h1>ddddd</h1>');
    }
     /**
     * @Route("/commande/vignette/delete/{id}", name="commande_vignette_delete")
     */
    public function deleteCommande($id)
    {
        $id = intVal($id);
        
        $entityManager = $this
        ->getDoctrine()
        ->getManager();
        
        $commandeVignette = $entityManager
        ->getRepository(CommandeVignette::class)
        ->find($id);
        
        $entityManager->remove($commandeVignette);
        $entityManager->flush();
        
        return new Response('<h1>ddddd</h1>');
    }
    
}
