<?php

namespace App\Controller;

use App\Entity\TrajetEvent;
use App\Form\TrajetEventType;
use App\Repository\TrajetEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trajet/event")
 */
class TrajetEventController extends AbstractController
{
    /**
     * @Route("/index", name="trajet_event_index", methods={"GET"})
     * @param TrajetEventRepository $trajetEventRepository
     * @return Response
     */
    public function index(TrajetEventRepository $trajetEventRepository): Response
    {
        return $this->render('trajet_event/index.html.twig', [
            'trajet_events' => $trajetEventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="trajet_event_new", methods={"GET","POST"})
     * @param Request $request
     * @param TrajetEventRepository $trajetRepo
     * @return Response
     */
    public function new(Request $request, TrajetEventRepository $trajetRepo): Response
    {
        $trajetEvent = new TrajetEvent();
        $form = $this->createForm(TrajetEventType::class, $trajetEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($trajetEvent->getArrivee() === $trajetEvent->getDepart() || strcmp(strtoupper($trajetEvent->getDepart()), strtoupper($trajetEvent->getArrivee())) === 0)
            {
                //CETTE FONCTION VERIFIE SI LES DEUX INFOS NE SONT PAS EGALES
                return $this->render('trajet_event/new.html.twig', [
                    'trajet_event' => $trajetEvent,
                    'error' => "Le depart doit être différent de l'arrivée",
                    'form' => $form->createView(),
                ]);
            }
            //VERIFIE SI LE TRAJET EXISTE
            $trajet = $trajetRepo->findOneBy([
                'depart' => $trajetEvent->getDepart(),
                'arrivee' => $trajetEvent->getArrivee(),
                'evenement' => $trajetEvent->getEvenement(),
//                'section' => $trajetEvent->getSection()
            ]);
            //SI LE TRAJET N'EXISTE PAS ON AJOUTE  SINON NOTHING
            if(!$trajet)
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($trajetEvent);
                $entityManager->flush();

                return $this->redirectToRoute('trajet_event_index');
            }
            else
            {
                return $this->render('trajet_event/new.html.twig', [
                    'trajet_event' => $trajetEvent,
                    'error' => 'Le trajet existe dejà',
                    'form' => $form->createView(),
                ]);
            }
        }

        return $this->render('trajet_event/new.html.twig', [
            'trajet_event' => $trajetEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trajet_event_show", methods={"GET"})
     * @param TrajetEvent $trajetEvent
     * @return Response
     */
    public function show(TrajetEvent $trajetEvent): Response
    {
        return $this->render('trajet_event/show.html.twig', [
            'trajet_event' => $trajetEvent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="trajet_event_edit", methods={"GET","POST"})
     * @param Request $request
     * @param TrajetEvent $trajetEvent
     * @return Response
     */
    public function edit(Request $request, TrajetEvent $trajetEvent): Response
    {
        $form = $this->createForm(TrajetEventType::class, $trajetEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trajet_event_index', [
                'id' => $trajetEvent->getId(),
            ]);
        }

        return $this->render('trajet_event/edit.html.twig', [
            'trajet_event' => $trajetEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trajet_event_delete", methods={"DELETE"})
     * @param Request $request
     * @param TrajetEvent $trajetEvent
     * @return Response
     */
    public function delete(Request $request, TrajetEvent $trajetEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trajetEvent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trajetEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trajet_event_index');
    }
}
