<?php

namespace App\Controller;

use App\Entity\BilletEvent;
use App\Form\BilletEventType;
use App\Repository\BilletEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/billet/event")
 */
class BilletEventController extends AbstractController
{
    /**
     * @Route("/", name="billet_event_index", methods={"GET","POST"})
     * @param Request $request
     * @param BilletEventRepository $billetEventRepository
     * @return Response
     */
    public function index(Request $request, BilletEventRepository $billetEventRepository): Response
    {
        $billetEvent = new BilletEvent();
        $form = $this->createForm(BilletEventType::class, $billetEvent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($billetEvent);
            $entityManager->flush();

            return $this->render('billet_event/index.html.twig', [
                'form' => $form->createView(),
                'success' => 'Le trajet est ajouté avec succès',
                'billet_events' => $billetEventRepository->findAll(),
            ]);
        }
        return $this->render('billet_event/index.html.twig', [
            'form' => $form->createView(),
            'billet_events' => $billetEventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="billet_event_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $billetEvent = new BilletEvent();
        $form = $this->createForm(BilletEventType::class, $billetEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($billetEvent);
            $entityManager->flush();

            return $this->redirectToRoute('billet_event_index');
        }

        return $this->render('billet_event/new.html.twig', [
            'billet_event' => $billetEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_event_show", methods={"GET"})
     * @param BilletEvent $billetEvent
     * @return Response
     */
    public function show(BilletEvent $billetEvent): Response
    {
        return $this->render('billet_event/show.html.twig', [
            'billet_event' => $billetEvent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="billet_event_edit", methods={"GET","POST"})
     * @param Request $request
     * @param BilletEvent $billetEvent
     * @return Response
     */
    public function edit(Request $request, BilletEvent $billetEvent): Response
    {
        $form = $this->createForm(BilletEventType::class, $billetEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('billet_event_index', [
                'id' => $billetEvent->getId(),
            ]);
        }

        return $this->render('billet_event/edit.html.twig', [
            'billet_event' => $billetEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_event_delete", methods={"DELETE"})
     * @param Request $request
     * @param BilletEvent $billetEvent
     * @return Response
     */
    public function delete(Request $request, BilletEvent $billetEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$billetEvent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($billetEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('billet_event_index');
    }
}
