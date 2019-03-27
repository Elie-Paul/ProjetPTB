<?php

namespace App\Controller;

use App\Entity\SectionEvent;
use App\Form\SectionEventType;
use App\Repository\SectionEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/section/event")
 */
class SectionEventController extends AbstractController
{
    /**
     * @Route("/index", name="section_event_index", methods={"GET"})
     * @param SectionEventRepository $sectionEventRepository
     * @return Response
     */
    public function index(SectionEventRepository $sectionEventRepository): Response
    {
        return $this->render('section_event/index.html.twig', [
            'section_events' => $sectionEventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="section_event_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $sectionEvent = new SectionEvent();
        $form = $this->createForm(SectionEventType::class, $sectionEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectionEvent);
            $entityManager->flush();

            return $this->redirectToRoute('section_event_index');
        }

        return $this->render('section_event/new.html.twig', [
            'section_event' => $sectionEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="section_event_show", methods={"GET"})
     * @param SectionEvent $sectionEvent
     * @return Response
     */
    public function show(SectionEvent $sectionEvent): Response
    {
        return $this->render('section_event/show.html.twig', [
            'section_event' => $sectionEvent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="section_event_edit", methods={"GET","POST"})
     * @param Request $request
     * @param SectionEvent $sectionEvent
     * @return Response
     */
    public function edit(Request $request, SectionEvent $sectionEvent): Response
    {
        $form = $this->createForm(SectionEventType::class, $sectionEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('section_event_index', [
                'id' => $sectionEvent->getId(),
            ]);
        }

        return $this->render('section_event/edit.html.twig', [
            'section_event' => $sectionEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="section_event_delete", methods={"DELETE"})
     * @param Request $request
     * @param SectionEvent $sectionEvent
     * @return Response
     */
    public function delete(Request $request, SectionEvent $sectionEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sectionEvent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sectionEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('section_event_index');
    }
}
