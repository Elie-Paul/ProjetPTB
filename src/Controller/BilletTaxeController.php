<?php

namespace App\Controller;

use App\Entity\BilletTaxe;
use App\Form\BilletTaxeType;
use App\Entity\StockTaxe;
use App\Entity\CommandeTaxe;
use App\Controller\CommandeTaxeController2;
use App\Repository\BilletTaxeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/billet/taxe")
 */
class BilletTaxeController extends AbstractController
{
    /**
     * @Route("/", name="billet_taxe_index", methods={"GET"})
     */
    public function index(BilletTaxeRepository $billetTaxeRepository,Request $request,CommandeTaxeController2 $controller): Response
    {
        $array = array();
        foreach ($billetTaxeRepository->findAll() as $key => $value) 
        {
            $arr = array();
            $id = $value->getId();
            $total = intVal($controller->totalBillet2($id));
            $arr = ['billet' => $value,'total' => $total];
            array_push($array,$arr);
        }
    

    return $this->render('billet_taxe/index.html.twig', [
        'billet_taxes' =>$array,
    ]);
    }

    /**
     * @Route("/index2", name="billet_taxe_index2", methods={"GET"})
     * @param BilletTaxeRepository $billetTaxeRepository
     * @return Response
     */
    public function index2(BilletTaxeRepository $billetTaxeRepository, Request $request): Response
    {
        $billetTaxe = new BilletTaxe();
        return $this->render('billet_taxe/index2.html.twig', [
            'billet_taxes' => $billetTaxeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="billet_taxe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $billetTaxe = new BilletTaxe();
        $stockPtb = new StockTaxe();
        $form = $this->createForm(BilletTaxeType::class, $billetTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $billetTaxe->setCreatedAt($this->test35());
            $billetTaxe->setUpdatedAt($this->test35());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($billetTaxe);
            $stockPtb->setBillet($billetTaxe);
                $stockPtb->setNbre(0);
                $stockPtb->setCreatedAt($this->test35());
                $stockPtb->setUpdatedAt($this->test35());
                $entityManager->persist($stockPtb);
            $entityManager->flush();

            return $this->redirectToRoute('billet_taxe_index');
        }

        return $this->render('billet_taxe/new.html.twig', [
            'billet_taxe' => $billetTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_taxe_show", methods={"GET"})
     */
    public function show(BilletTaxe $billetTaxe): Response
    {
        return $this->render('billet_taxe/show.html.twig', [
            'billet_taxe' => $billetTaxe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="billet_taxe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BilletTaxe $billetTaxe): Response
    {
        $form = $this->createForm(BilletTaxeType::class, $billetTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('billet_taxe_index', [
                'id' => $billetTaxe->getId(),
            ]);
        }

        return $this->render('billet_taxe/edit.html.twig', [
            'billet_taxe' => $billetTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_taxe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BilletTaxe $billetTaxe): Response
    {
        $commande = $this->getDoctrine()->getRepository(CommandeTaxe::class)->findOneBy([
            'billet' => $billetTaxe
        ]);
        if($commande)
        {
            return $this->render('billet_taxe/show.html.twig', [
                'billet_taxe' => $billetTaxe,
                'error' => "Il y'a une contrainte d'integrité entre 'Commande PTB' et 'Billet PTB'"
            ]);
        }
        if ($this->isCsrfTokenValid('delete'.$billetTaxe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($billetTaxe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('billet_taxe_index');
    }
}
