<?php

namespace App\Controller;

use App\Entity\BilletPtb;
use App\Form\BilletPtbType;
use App\Repository\BilletPtbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/billet/ptb")
 */
class BilletPtbController extends AbstractController
{
    /**
     * @Route("/", name="billet_ptb_index", methods={"GET"})
     * @param BilletPtbRepository $billetPtbRepository
     * @return Response
     */
    public function index(BilletPtbRepository $billetPtbRepository): Response
    {
        return $this->render('billet_ptb/index.html.twig', [
            'billet_ptbs' => $billetPtbRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="billet_ptb_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $billetPtb = new BilletPtb();
        $form = $this->createForm(BilletPtbType::class, $billetPtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($billetPtb);
            $entityManager->flush();

            return $this->redirectToRoute('billet_ptb_index');
        }

        return $this->render('billet_ptb/new.html.twig', [
            'billet_ptb' => $billetPtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_ptb_show", methods={"GET"})
     * @param BilletPtb $billetPtb
     * @return Response
     */
    public function show(BilletPtb $billetPtb): Response
    {
        return $this->render('billet_ptb/show.html.twig', [
            'billet_ptb' => $billetPtb,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="billet_ptb_edit", methods={"GET","POST"})
     * @param Request $request
     * @param BilletPtb $billetPtb
     * @return Response
     */
    public function edit(Request $request, BilletPtb $billetPtb): Response
    {
        $form = $this->createForm(BilletPtbType::class, $billetPtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('billet_ptb_index', [
                'id' => $billetPtb->getId(),
            ]);
        }

        return $this->render('billet_ptb/edit.html.twig', [
            'billet_ptb' => $billetPtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_ptb_delete", methods={"DELETE"})
     * @param Request $request
     * @param BilletPtb $billetPtb
     * @return Response
     */
    public function delete(Request $request, BilletPtb $billetPtb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$billetPtb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($billetPtb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('billet_ptb_index');
    }
}
