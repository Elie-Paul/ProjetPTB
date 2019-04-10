<?php

namespace App\Controller;

use App\Entity\StockTaxe;
use App\Form\StockTaxeType;
use App\Repository\StockTaxeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stock/t")
 */
class StockTaxeController extends AbstractController
{
    /**
     * @Route("/", name="stock_taxe_listertaxe", methods={"GET"})
     */
    public function index(StockTaxeRepository $stockTaxeRepository): Response
    {
        return $this->render('stock_taxe/index.html.twig', [
            'stock_taxes' => $stockTaxeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="stock_taxe_nouveau", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stockTaxe = new StockTaxe();
        $form = $this->createForm(StockTaxeType::class, $stockTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stockTaxe);
            $entityManager->flush();

            return $this->redirectToRoute('stock_taxe_listertaxe');
        }

        return $this->render('stock_taxe/new.html.twig', [
            'stock_taxe' => $stockTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_taxe_voir", methods={"GET"})
     */
    public function show(StockTaxe $stockTaxe): Response
    {
        return $this->render('stock_taxe/show.html.twig', [
            'stock_taxe' => $stockTaxe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stock_taxe_modifier", methods={"GET","POST"})
     */
    public function edit(Request $request, StockTaxe $stockTaxe): Response
    {
        $form = $this->createForm(StockTaxeType::class, $stockTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock_taxe_listertaxe', [
                'id' => $stockTaxe->getId(),
            ]);
        }

        return $this->render('stock_taxe/edit.html.twig', [
            'stock_taxe' => $stockTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_taxe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StockTaxe $stockTaxe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockTaxe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stockTaxe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock_taxe_listertaxe');
    }
}
