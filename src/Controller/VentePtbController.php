<?php

namespace App\Controller;

use App\Entity\VentePtb;
use App\Form\VentePtbType;
use App\Repository\VentePtbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vente/ptb")
 */
class VentePtbController extends AbstractController
{
    /**
     * @Route("/", name="vente_ptb_index", methods={"GET"})
     */
    public function index(VentePtbRepository $ventePtbRepository): Response
    {
        return $this->render('vente_ptb/index.html.twig', [
            'vente_ptbs' => $ventePtbRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vente_ptb_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ventePtb = new VentePtb();
        $form = $this->createForm(VentePtbType::class, $ventePtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ventePtb);
            $entityManager->flush();

            return $this->redirectToRoute('vente_ptb_index');
        }

        return $this->render('vente_ptb/new.html.twig', [
            'vente_ptb' => $ventePtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_ptb_show", methods={"GET"})
     */
    public function show(VentePtb $ventePtb): Response
    {
        return $this->render('vente_ptb/show.html.twig', [
            'vente_ptb' => $ventePtb,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vente_ptb_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VentePtb $ventePtb): Response
    {
        $form = $this->createForm(VentePtbType::class, $ventePtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_ptb_index', [
                'id' => $ventePtb->getId(),
            ]);
        }

        return $this->render('vente_ptb/edit.html.twig', [
            'vente_ptb' => $ventePtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_ptb_delete", methods={"DELETE"})
     */
    public function delete(Request $request, VentePtb $ventePtb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ventePtb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ventePtb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vente_ptb_index');
    }
}
