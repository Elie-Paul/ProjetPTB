<?php

namespace App\Controller;

use App\Entity\Tracabilite;
use App\Form\TracabiliteType;
use App\Repository\TracabiliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tracabilite")
 */
class TracabiliteController extends AbstractController
{
    /**
     * @Route("/", name="tracabilite_index", methods={"GET"})
     */
    public function index(TracabiliteRepository $tracabiliteRepository): Response
    {
        return $this->render('tracabilite/index.html.twig', [
            'tracabilites' => $tracabiliteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tracabilite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tracabilite = new Tracabilite();
        $form = $this->createForm(TracabiliteType::class, $tracabilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tracabilite);
            $entityManager->flush();

            return $this->redirectToRoute('tracabilite_index');
        }

        return $this->render('tracabilite/new.html.twig', [
            'tracabilite' => $tracabilite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tracabilite_show", methods={"GET"})
     */
    public function show(Tracabilite $tracabilite): Response
    {
        return $this->render('tracabilite/show.html.twig', [
            'tracabilite' => $tracabilite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tracabilite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tracabilite $tracabilite): Response
    {
        $form = $this->createForm(TracabiliteType::class, $tracabilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tracabilite_index', [
                'id' => $tracabilite->getId(),
            ]);
        }

        return $this->render('tracabilite/edit.html.twig', [
            'tracabilite' => $tracabilite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tracabilite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tracabilite $tracabilite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tracabilite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tracabilite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tracabilite_index');
    }
}
