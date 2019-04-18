<?php

namespace App\Controller;

use App\Entity\CommandeTaxe;
use App\Form\CommandeTaxeType;
use App\Repository\CommandeTaxeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\BilletTaxe;
use App\Entity\StockTaxe;
use App\Entity\VenteTaxe;
use App\Entity\User;
use App\Entity\Audit;
use App\Entity\TypeAudit;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande/t")
 */
class CommandeTaxeController extends AbstractController
{
    /**
     * @Route("/", name="commande_taxe_lister", methods={"GET"})
     */
    public function index(CommandeTaxeRepository $commandeTaxeRepository): Response
    {
        return $this->render('commande_taxe/index.html.twig', [
            'commande_taxes' => $commandeTaxeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commande_taxe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandeTaxe = new CommandeTaxe();
        $form = $this->createForm(CommandeTaxeType::class, $commandeTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandeTaxe);
            $entityManager->flush();

            return $this->redirectToRoute('commande_taxe_lister');
        }

        return $this->render('commande_taxe/new.html.twig', [
            'commande_taxe' => $commandeTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_taxe_voir", methods={"GET"})
     */
    public function show(CommandeTaxe $commandeTaxe): Response
    {
        return $this->render('commande_taxe/show.html.twig', [
            'commande_taxe' => $commandeTaxe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_taxe_modifier1", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandeTaxe $commandeTaxe): Response
    {
        $form = $this->createForm(CommandeTaxeType::class, $commandeTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_taxe_lister', [
                'id' => $commandeTaxe->getId(),
            ]);
        }

        return $this->render('commande_taxe/edit.html.twig', [
            'commande_taxe' => $commandeTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_taxe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandeTaxe $commandeTaxe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeTaxe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandeTaxe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_taxe_lister');
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
            $audit->setCreatedAt($this->test35());
            $audit->setUpdatedAt($this->test35());
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
            $audit->setCreatedAt($this->test35());
            $audit->setUpdatedAt($this->test35());
            $entityManager->persist($audit);
        }
        
        
        $entityManager->flush();
        
        return new Response('<h1>'.$billet->getId().'</h1>');
    }
}
