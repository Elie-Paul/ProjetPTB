<?php


namespace App\Controller\JsonEvent;
use App\Entity\BilletEvent;
use App\Entity\SectionEvent;
use App\Entity\TrajetEvent;
use App\Form\BilletEventType;
use App\Form\SectionEventType;
use App\Form\TrajetEventType;
use App\Repository\BilletEventRepository;
use App\Repository\EvenementRepository;
use App\Repository\SectionEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EventController extends AbstractController
{
    /**
     * @Route("event/modal/section/json/new", name="section_event_modal_json_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newModalSection(Request $request): Response
    {
        $sectionEvent = new SectionEvent();
        $trajetEvent = new TrajetEvent();
        $formTrajet = $this->createForm(TrajetEventType::class, $trajetEvent);
        $formSection = $this->createForm(SectionEventType::class, $sectionEvent);
        $formSection->handleRequest($request);
        if($request->isXmlHttpRequest())
        {
            if($formSection->isSubmitted() )
            {
                $lib = $this->getDoctrine()->getRepository(SectionEvent::class)->findOneBy(['libelle' => $sectionEvent->getLibelle()]);
                $prix = $this->getDoctrine()->getRepository(SectionEvent::class)->findOneBy(['prix' => $sectionEvent->getPrix()]);
                if($lib)
                {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => $lib->getLibelle().' existe dejà'
                    ]);
                }
                if($prix)
                {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Deux sections ne peuvent pas avoir le même prix'
                    ]);
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($sectionEvent);
                $entityManager->flush();
                return new JsonResponse([
                    'status' => 'success',
                    'message' => 'La section a été ajouté avec succès',
                ]);
            }
        }
    }


    /**
     * @Route("event/modal/trajet/json/new", name="trajet_event_modal_json_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newModalTrajet(Request $request): Response
    {
        $trajetEvent = new TrajetEvent();
        $formTrajet = $this->createForm(TrajetEventType::class, $trajetEvent);
        $formTrajet->handleRequest($request);
        if($request->isXmlHttpRequest())
        {
            if($formTrajet->isSubmitted() )
            {
                if($trajetEvent->getArrivee() === $trajetEvent->getDepart() || strcmp(strtoupper($trajetEvent->getDepart()), strtoupper($trajetEvent->getArrivee())) === 0)
                {
                    //CETTE FONCTION VERIFIE SI LES DEUX INFOS NE SONT PAS EGALES
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => "Le dapart doit être different de l'arrivée"
                    ]);
                }

                //VERIFIE SI LE TRAJET EXISTE
                $trajet = $this->getDoctrine()->getRepository(TrajetEvent::class)->findOneBy([
                    'depart' => $trajetEvent->getDepart(),
                    'arrivee' => $trajetEvent->getArrivee(),
                    'evenement' => $trajetEvent->getEvenement(),
                ]);
                //SI LE TRAJET N'EXISTE PAS ON AJOUTE  SINON NOTHING
                if(!$trajet)
                {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($trajetEvent);
                    $entityManager->flush();

                    return new JsonResponse([
                        'status' => 'success',
                        'message' => "Le trajet est ajouté avec succès "
                    ]);
                }
                else
                {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => "Ce trajet existe dejà pour ".$trajet->getEvenement()->getLibelle()
                    ]);
                }
            }
        }
    }


    /**
     * @Route("event/modal/billet/json/new", name="billet_event_modal_json_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newModalBillet(Request $request): Response
    {
        $billetEvent = new BilletEvent();
        $form = $this->createForm(BilletEventType::class, $billetEvent);
        $form->handleRequest($request);
        if($request->isXmlHttpRequest())
        {
            if ($form->isSubmitted())
            {
                $billet = $this->getDoctrine()->getRepository(BilletEvent::class)->findOneBy([
                    'trajet' => $billetEvent->getTrajet()
                ]);
                if($billet)
                {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Il existe dejà un billet pour le trajet '.$billetEvent->getTrajet()
                    ]);
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($billetEvent);
                $entityManager->flush();
                return new JsonResponse([
                    'status' => 'success',
                    'message' => 'Le billet du trajet '.$billetEvent->getTrajet().' est crée pour le guichet '.$billetEvent->getGuichet()->getNom(),
//                    'billets' => $billetEventRepository->findAll()
                ]);
            }
        }
    }
}