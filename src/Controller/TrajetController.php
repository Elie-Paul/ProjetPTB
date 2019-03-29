<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Repository\TrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trajet")
 */
class TrajetController extends AbstractController
{
    /**
     * @Route("/", name="trajet_index", methods={"GET"})
     */
    public function index(TrajetRepository $trajetRepository): Response
    {
        return $this->render('trajet/index.html.twig', [
            'trajets' => $trajetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="trajet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        dump($trajet);
        $repository = $this->getDoctrine()->getRepository(Trajet::class);
        $repo = $repository->findAll();

       /* foreach ($repo as $key => $var) {
            if ($var->getDepart() == $trajet->getDepart() || $var->getArrivee() == $trajet->getArrivee()) {
                echo "Trajet deja creer";
            }
        }*/


        if ($form->isSubmitted() && $form->isValid()) {
            $trajet->setCreatedAt(new \DateTime());
            $trajet->setUpdatedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trajet);
            $entityManager->flush();

            /// Message de confirmation
            $this->addFlash('success','Trajet '.$trajet->getDepart()->getLibelle().'-'.$trajet->getArrivee()->getLibelle().' a été créer');

            return $this->redirectToRoute('trajet_index');
        }

        return $this->render('trajet/new.html.twig', [
            'trajet' => $trajet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trajet_show", methods={"GET"})
     */
    public function show(Trajet $trajet): Response
    {
        return $this->render('trajet/show.html.twig', [
            'trajet' => $trajet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="trajet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Trajet $trajet): Response
    {
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trajet->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trajet_index', [
                'id' => $trajet->getId(),
            ]);
        }

        return $this->render('trajet/edit.html.twig', [
            'trajet' => $trajet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trajet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Trajet $trajet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trajet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trajet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trajet_index');
    }
}
