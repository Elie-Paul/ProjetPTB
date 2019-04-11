<?php

namespace App\Controller;

use App\Entity\VenteTaxe;
use App\Form\VenteTaxeType;
use App\Repository\VenteTaxeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vente/taxe")
 */
class VenteTaxeController extends AbstractController
{
    /**
     * @Route("/", name="vente_taxe_index", methods={"GET"})
     */
    public function index(VenteTaxeRepository $venteTaxeRepository): Response
    {
        return $this->render('vente_taxe/index.html.twig', [
            'vente_taxes' => $venteTaxeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vente_taxe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $venteTaxe = new VenteTaxe();
        $form = $this->createForm(VenteTaxeType::class, $venteTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($venteTaxe);
            $entityManager->flush();

            return $this->redirectToRoute('vente_taxe_index');
        }

        return $this->render('vente_taxe/new.html.twig', [
            'vente_taxe' => $venteTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_taxe_show", methods={"GET"})
     */
    public function show(VenteTaxe $venteTaxe): Response
    {
        return $this->render('vente_taxe/show.html.twig', [
            'vente_taxe' => $venteTaxe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vente_taxe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VenteTaxe $venteTaxe): Response
    {
        $form = $this->createForm(VenteTaxeType::class, $venteTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_taxe_index', [
                'id' => $venteTaxe->getId(),
            ]);
        }

        return $this->render('vente_taxe/edit.html.twig', [
            'vente_taxe' => $venteTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_taxe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, VenteTaxe $venteTaxe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$venteTaxe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($venteTaxe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vente_taxe_index');
    }
}
