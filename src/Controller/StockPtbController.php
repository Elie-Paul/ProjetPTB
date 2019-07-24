<?php

namespace App\Controller;

use App\Entity\StockPtb;
use App\Form\StockPtbType;
use App\Entity\Guichet;
use App\Entity\BilletPtb;
use App\Entity\Audit;
use App\Repository\StockPtbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stock/p")
 */
class StockPtbController extends AbstractController
{
    /**
     * @Route("/", name="stock_ptb_lister", methods={"GET"})
     */
    public function index(StockPtbRepository $stockPtbRepository): Response
    {
        return $this->render('stock_ptb/index.html.twig', [
            'stock_ptbs' => $stockPtbRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="stock_ptb_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stockPtb = new StockPtb();
        $form = $this->createForm(StockPtbType::class, $stockPtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stockPtb);
            $entityManager->flush();

            return $this->redirectToRoute('stock_ptb_lister');
        }

        return $this->render('stock_ptb/new.html.twig', [
            'stock_ptb' => $stockPtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_ptb_voir", methods={"GET"})
     */
    public function show(StockPtb $stockPtb): Response
    {
        return $this->render('stock_ptb/show.html.twig', [
            'stock_ptb' => $stockPtb,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stock_ptb_modifierst", methods={"GET","POST"})
     */
    public function edit(Request $request, StockPtb $stockPtb): Response
    {
        $form = $this->createForm(StockPtbType::class, $stockPtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $date->setTimezone(new \DateTimeZone('GMT'));
            $stockPtb->setUpdatedAt($date);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock_ptb_lister', [
                'id' => $stockPtb->getId(),
            ]);
        }

        return $this->render('stock_ptb/edit.html.twig', [
            'stock_ptb' => $stockPtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_ptb_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StockPtb $stockPtb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockPtb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stockPtb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock_ptb_lister');
    }
}
