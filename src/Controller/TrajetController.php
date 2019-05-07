<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Entity\Navette;
use App\Entity\Ptb;
use App\Entity\Lieux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            'trajets' => $trajetRepository->findBy(array(), array('createdAt' => 'DESC'))
        ]);
    }

    /**
     * @Route("/new", name="trajet_new", methods={"GET","POST"})
     */
    public function new(Request $request, TrajetRepository $trajetRepo): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trajet1 = $trajetRepo->findOneBy([
                'depart' => $trajet->getDepart(),
                'arrivee' => $trajet->getArrivee()
            ]);

            if (!$trajet1) {
                $trajet->setCreatedAt($this->test35());
                $trajet->setUpdatedAt($this->test35());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($trajet);
                $entityManager->flush();

                /// Message de confirmation
                //$this->addFlash('info','Trajet '.$trajet->getDepart()->getLibelle().'-'.$trajet->getArrivee()->getLibelle().' a été créer');

                return $this->render('trajet/index.html.twig', [
                    'success' => 'Trajet '.$trajet->getDepart()->getLibelle().'-'.$trajet->getArrivee()->getLibelle().' a été créer',
                    'trajets' => $trajetRepo->findAll(),
                ]);
            }else {

                return $this->render('trajet/new.html.twig', [
                    'trajet' => $trajet,
                    'error' => 'Le trajet '.$trajet->getDepart()->getLibelle().'-'.$trajet->getArrivee()->getLibelle().' existe dejà',
                    'form' => $form->createView(),
                ]);
            }
            
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
        //$form = $this->createForm(TrajetType::class, $trajet);
        //$form->handleRequest($request);

        $form = $this->createFormBuilder($trajet)
                ->add('depart', EntityType::class, [
                    'class' => Lieux::class,
                    'choice_label' => 'libelle'
                ])
                ->add('arrivee', EntityType::class, [
                    'class' => Lieux::class,
                    'choice_label' => 'libelle'
                ])
                ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trajet->setUpdatedAt($this->test35());
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
        $ptb = $this->getDoctrine()->getRepository(Ptb::class)->findOneBy([
            'trajet' => $trajet
        ]);
        $navette = $this->getDoctrine()->getRepository(Navette::class)->findOneBy([
            'trajet' => $trajet
        ]);
        if($ptb)
        {
            return $this->render('trajet/show.html.twig', [
            'trajet' => $trajet,
            'error' => "Il y'a une contrainte d'integrité entre 'Trajet' et 'PTB'"
        ]);
        }


        if($navette)
        {
            return $this->render('trajet/show.html.twig', [
            'trajet' => $trajet,
            'erreur' => "Il y'a une contrainte d'integrité entre 'Trajet' et 'Navette'"
        ]);
        }
        if ($this->isCsrfTokenValid('delete'.$trajet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trajet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trajet_index');
    }
}
