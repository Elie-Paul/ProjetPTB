<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Form\LieuxType;
use App\Repository\LieuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lieux")
 */
class LieuxController extends AbstractController
{
    /**
     * @Route("/", name="lieux_index", methods={"GET"})
     */
    public function index(LieuxRepository $lieuxRepository): Response
    {
        return $this->render('lieux/index.html.twig', [
            'lieuxes' => $lieuxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lieux_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lieux = new Lieux();
        $form = $this->createForm(LieuxType::class, $lieux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lieux);
            $entityManager->flush();

            return $this->redirectToRoute('lieux_index');
        }

        return $this->render('lieux/new.html.twig', [
            'lieux' => $lieux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lieux_show", methods={"GET"})
     */
    public function show(Lieux $lieux): Response
    {
        return $this->render('lieux/show.html.twig', [
            'lieux' => $lieux,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lieux_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lieux $lieux): Response
    {
        $form = $this->createForm(LieuxType::class, $lieux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lieux_index', [
                'id' => $lieux->getId(),
            ]);
        }

        return $this->render('lieux/edit.html.twig', [
            'lieux' => $lieux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lieux_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lieux $lieux): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lieux->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lieux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lieux_index');
    }
}
