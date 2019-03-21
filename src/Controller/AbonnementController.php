<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Repository\AbonnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/abonnement")
 */
class AbonnementController extends AbstractController
{
    /**
     * @Route("/", name="abonnement_index", methods={"GET"})
     * @param AbonnementRepository $abonnementRepository
     * @return Response
     */
    public function index(AbonnementRepository $abonnementRepository): Response
    {
        return $this->render('abonnement/index.html.twig', [
            'abonnements' => $abonnementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="abonnement_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);
        $abonnement->setCreatedAt(new \DateTime());
        $abonnement->setUpdateAt(new \DateTime());
        $expiration = new \DateTime();
        $abonnement->setExpiration($expiration->add(new \DateInterval('P12M')));


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($abonnement);
            $entityManager->flush();

            return $this->redirectToRoute('abonnement_index');
        }

        return $this->render('abonnement/new.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
            'expiration' => $abonnement->get
        ]);
    }

    /**
     * @Route("/{id}", name="abonnement_show", methods={"GET"})
     * @param Abonnement $abonnement
     * @return Response
     */
    public function show(Abonnement $abonnement): Response
    {
        return $this->render('abonnement/show.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="abonnement_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Abonnement $abonnement
     * @return Response
     */
    public function edit(Request $request, Abonnement $abonnement): Response
    {
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('abonnement_index', [
                'id' => $abonnement->getId(),
            ]);
        }

        return $this->render('abonnement/edit.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/valider/{id}", name="valider_carte")
     * @param Request $request
     * @param Abonnement $abonnement
     * @return Response
     * @throws \Exception
     */
    public function validerCarte(Request $request, Abonnement $abonnement): Response
    {
        $abonnement->setNombreCarte(1);
        $abonnement->setUpdateAt(new \DateTime());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('abonnement_index');
    }

    /**
     * @Route("/retablir/{id}", name="retablir_carte")
     * @param Abonnement $abonnement
     * @return Response
     * @throws \Exception
     */
    public function retablirCarte(Abonnement $abonnement): Response
    {
        $abonnement->setNombreCarte(0);
        $abonnement->setCreatedAt(new \DateTime());
        $abonnement->setUpdateAt(new \DateTime());
        $expiration = new \DateTime();
        $abonnement->setExpiration($expiration->add(new \DateInterval('P12M')));
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('abonnement_index');
    }


    /**
     * @Route("/{id}", name="abonnement_delete", methods={"DELETE"})
     * @param Request $request
     * @param Abonnement $abonnement
     * @return Response
     */
    public function delete(Request $request, Abonnement $abonnement): Response
    {
        if ($this->isCsrfTokenValid('delete' . $abonnement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($abonnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('abonnement_index');
    }
}
