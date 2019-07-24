<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Guichet;
use App\Entity\Trajet;
use App\Entity\Section;
use App\Entity\BilletPtb;
use App\Entity\Ptb;
use App\Entity\User;
use App\Entity\CommandePtb;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lieux;
use App\Entity\Audit;
use App\Entity\TypeAudit;

class AuditController2Controller extends AbstractController
{
    /**
     * @Route("/audit/controller2", name="audit_controller2")
     */
    public function index()
    {
        return $this->render('audit_controller2/index.html.twig', [
            'controller_name' => 'AuditController2Controller',
        ]);
    }
    /**
     * @Route("/audit/impression", name="audit_impression")
     */
    public function newImpression(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(intval(1));
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription($text);
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }

    /**
     * @Route("/audit/commandebythera", name="audit_commandebythera")
     */
    public function newCommandPtb(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(5);
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription("Une commande pour le billet PTB a été effectué");
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }

    /**
     * @Route("/audit/altererstockptb", name="audit_altererstockptb")
     */
    public function newAlterStockPtb(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(10);
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription("Stock PTB a été modifié");
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }

    /**
     * @Route("/audit/altererstocknavette", name="audit_altererstocknavette")
     */
    public function newAlterStockAutorail(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(11);
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription("Le stock autorail a été modifié");
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }

    /**
     * @Route("/audit/altererstocktaxe", name="audit_altererstocktaxe")
     */
    public function newAlterStockTaxe(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(12);
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription("Le stock taxe a été modifié");
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }

    /**
     * @Route("/audit/altererstockvignette", name="audit_altererstockvignette")
     */
    public function newAlterStockVignette(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(13);
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription("Le stock vignette a été modifié");
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }

    /**
     * @Route("/audit/commandenavettebythera", name="audit_commandenavettebythera")
     */
    public function newCommandNavette(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(6);
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription("Une commande pour le billet autorail a été effectué");
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }

    /**
     * @Route("/audit/commandevignettebythera", name="audit_commandevignettebythera")
     */
    public function newCommandVignette(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(7);
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription("Une commande de vignette a été effectué");
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }

    /**
     * @Route("/audit/commandevignettebythera", name="audit_commandevignettebythera")
     */
    public function newValiderPtb(Request $request)
    {
       $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(8);
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription("Une commande PTB a été validé");
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
    }
    
    /**
     * @Route("/audit/reimpression", name="audit_reimpression")
     */
    public function reImpression2(Request $request)
    {   
        
        $array= explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $text=$array[1];
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(intval(2));
        $audit = new Audit();
        $audit->setUser($user);
        $audit->setType($type);
        $audit->setDescription($text);
        $audit->setCreatedAt($this->test35());
        $audit->setUpdatedAt($this->test35());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($audit);
        $entityManager->flush();
        return new Response(
            "<h1>".$type->getLibelle()."</h1>"
        );
        
    }

     /**
     * @Route("/Json/audit", name="getAudit")
     */
    public function getAudit()
    {
        $audits = $this->getDoctrine()->getRepository(Audit::class)->findBy(array(), array('createdAt' => 'DESC'));;
        $data = array();
        foreach ($audits as $key => $audit) 
        {
            
            $myarray = array
            (
                'id' => $audit->getId(),

                'userName' => $audit
                ->getUser()
                ->getUserName(),

                'Prenom' => $audit
                ->getUser()
                ->getPrenom(),

                'Nom' => $audit
                ->getUser()
                ->getNom(),

                'type' => $audit
                ->getType()
                ->getLibelle(),
                
                'description' =>$audit
                ->getDescription(),
            );
            array_push($data,$myarray);
        }
            return new Response(json_encode($data));
            //return new Response('dddd');
    }

}
