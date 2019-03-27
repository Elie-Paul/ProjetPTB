<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     * @param EvenementRepository $evenementRepository
     * @return Response
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
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
//        strtotime($date1) >= strtotime($date2);
        if ($form->isSubmitted() && $form->isValid()) {
//            dump(strcmp( $evenement->getDateEvent()->format('Y/m/d') , $evenement->getFinEvent()->format('Y/m/d')) );
//            die();
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
