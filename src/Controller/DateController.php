<?php

namespace App\Controller;

use App\Entity\Date;
use App\Form\DateType;
use App\Repository\DateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/date")
 */
class DateController extends AbstractController
{
    /**
     * @Route("/", name="date_index", methods={"GET"})
     */
    public function index(DateRepository $dateRepository): Response
    {
        return $this->render('date/index.html.twig', [
            'dates' => $dateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="date_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $date = new Date();
        $form = $this->createForm(DateType::class, $date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($date);
            $entityManager->flush();

            return $this->redirectToRoute('date_index');
        }

        return $this->render('date/new.html.twig', [
            'date' => $date,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="date_show", methods={"GET"})
     */
    public function show(Date $date): Response
    {
        return $this->render('date/show.html.twig', [
            'date' => $date,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="date_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Date $date): Response
    {
        $form = $this->createForm(DateType::class, $date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('date_index', [
                'id' => $date->getId(),
            ]);
        }

        return $this->render('date/edit.html.twig', [
            'date' => $date,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="date_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Date $date): Response
    {
        if ($this->isCsrfTokenValid('delete'.$date->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($date);
            $entityManager->flush();
        }

        return $this->redirectToRoute('date_index');
    }
}
