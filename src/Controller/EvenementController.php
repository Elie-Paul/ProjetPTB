<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\SectionEvent;
use App\Entity\TrajetEvent;
use App\Form\EvenementType;
use App\Form\SectionEventType;
use App\Form\TrajetEventType;
use App\Repository\EvenementRepository;
use App\Repository\TrajetEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET","POST"})
     * @param Request $request
     * @param TrajetEventRepository $trajetRepo
     * @param EvenementRepository $evenementRepository
     * @return Response
     */
    public function index(Request $request, TrajetEventRepository $trajetRepo, EvenementRepository $evenementRepository): Response
    {
        $sectionEvent = new SectionEvent();
        $trajetEvent = new TrajetEvent();
        $formTrajet = $this->createForm(TrajetEventType::class, $trajetEvent);
        $formSection = $this->createForm(SectionEventType::class, $sectionEvent);
//        ///////////////////////////////////////////////////////////////////////////////////////////////////////
        $formSection->handleRequest($request);
        $formTrajet->handleRequest($request);
        if ($formSection->isSubmitted() && $formSection->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectionEvent);
            $entityManager->flush();

            return $this->render('evenement/index.html.twig', [
                'section_event' => $sectionEvent,
                'evenements' => $evenementRepository->findAll(),
                'success' => 'La section est ajouté avec success',
                'formSection' => $formSection->createView(),
//                'formTrajet' => $formTrajet->createView(),
            ]);
        }

        if ($formTrajet->isSubmitted() && $formTrajet->isValid()) {
            if($trajetEvent->getArrivee() === $trajetEvent->getDepart() || strcmp(strtoupper($trajetEvent->getDepart()), strtoupper($trajetEvent->getArrivee())) === 0)
            {
                return $this->render('evenement/index.html.twig', [
                    'trajet_event' => $trajetEvent,
                    'evenements' => $evenementRepository->findAll(),
                    'error' => "Le depart doit être différent de l'arrivée",
                    'formSection' => $formSection->createView(),
                    'formTrajet' => $formTrajet->createView(),
                ]);
            }
            $trajet = $trajetRepo->findOneBy([
                'depart' => $trajetEvent->getDepart(),
                'arrivee' => $trajetEvent->getArrivee(),
                'evenement' => $trajetEvent->getEvenement(),
//                'section' => $trajetEvent->getSection()
            ]);
            if(!$trajet)
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($trajetEvent);
                $entityManager->flush();

                return $this->render('evenement/index.html.twig', [
                    'trajet_event' => $trajetEvent,
                    'evenements' => $evenementRepository->findAll(),
                    'success' => "Le trajet est ajouté avec success",
                    'formSection' => $formSection->createView(),
                    'formTrajet' => $formTrajet->createView(),
                ]);
            }
            else
            {
                return $this->render('evenement/index.html.twig', [
                    'trajet_event' => $trajetEvent,
                    'evenements' => $evenementRepository->findAll(),
                    'error' => "Ce trajet existe dejà",
                    'formSection' => $formSection->createView(),
                    'formTrajet' => $formTrajet->createView(),
                ]);
            }
        }
//        ///////////////////////////////////////////////////////////////////////////////////////////////////////
        return $this->render('evenement/index.html.twig', [
            'formTrajet' => $formTrajet->createView(),
            'trajet_event' => $trajetEvent,
            'formSection' => $formSection->createView(),
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement();
        $evenement->setCreatedAt(new \DateTime());
        $evenement->setUpdatedAt(new \DateTime());
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        $toDay = new \DateTime();
        if ($form->isSubmitted() && $form->isValid()) {

            if(strcmp( $evenement->getDateEvent()->format('Y/m/d') , $toDay->format('Y/m/d')) < 0)
            {
                return $this->render('evenement/new.html.twig', [
                    'evenement' => $evenement,
                    'error' => "La date de l'evement n'est pas valide",
                    'form' => $form->createView(),
                ]);
            }
            if(strcmp( $evenement->getDateEvent()->format('Y/m/d') , $evenement->getFinEvent()->format('Y/m/d'))  > 0)
            {
                return $this->render('evenement/new.html.twig', [
                    'evenement' => $evenement,
                    'error' => "La date de fin de l'evenement n'est pas valide",
                    'form' => $form->createView(),
                ]);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     * @param Evenement $evenement
     * @return Response
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Evenement $evenement
     * @return Response
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index', [
                'id' => $evenement->getId(),
            ]);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"DELETE"})
     * @param Request $request
     * @param Evenement $evenement
     * @return Response
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }
}
