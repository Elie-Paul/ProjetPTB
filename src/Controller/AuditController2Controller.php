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
        $audit->setType($type);
        $audit->setDescription($text);
        $audit->setCreatedAt(new \DateTime());
        $audit->setUpdatedAt(new \DateTime());
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
        explode('+',$request->getContent());
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(intval($array[0]));
        $nombreDebillet = intval($array[1]);
        $nombredeDepart = intval($array[2]);
        $text="impresionn de billet du N4 au N5";
        $type = $this->getDoctrine()
        ->getRepository(TypeAudit::class)
        ->find(intval(2));
        
    }

}
