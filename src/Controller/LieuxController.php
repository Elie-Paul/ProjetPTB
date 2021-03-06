<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Guichet;
use App\Entity\Trajet;
use App\Form\LieuxType;
use App\Repository\LieuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/lieux")
 */
class LieuxController extends AbstractController
{
    
    /**
     * @Route("/", name="lieux_index", methods={"GET"})
     */
    
    public function index(LieuxRepository $lieuxRepository): Response
    {
        return $this->render('lieux/index.html.twig', [
            'lieuxes' => $lieuxRepository->findBy(array(), array('createdAt' => 'DESC')),
        ]);
    }

    /**
     * @Route("/new", name="lieux_new", methods={"GET","POST"})
     */
    public function new(Request $request, LieuxRepository $lieuxRepository): Response
    {        
        $lieux = new Lieux();
        $form = $this->createForm(LieuxType::class, $lieux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {  
            
            $lieux1 = $lieuxRepository->findOneBy([
                'libelle' => $lieux->getLibelle()
            ]);

            if (!$lieux1) {
                $lieux->setCreatedAt($this->test35());
                $lieux->setUpdatedAt($this->test35());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($lieux);
                $entityManager->flush();
            /// Message de confirmation
            // $this->addFlash('info','Lieu '.$lieux->getLibelle().' a été créer');
            
                return $this->render('lieux/index.html.twig', [
                    'lieuxes' => $lieuxRepository->findAll(),
                    'success' => 'Lieu '.$lieux->getLibelle().' a été créer',
                ]);
                //return new Response("true");
            }else {
                return $this->render('lieux/new.html.twig', [
                    'lieux' => $lieux,
                    'form' => $form->createView(),
                    'error' => 'Lieu '.$lieux->getLibelle().' existe déjà',
                ]);
            }
            
        }

        return $this->render('lieux/new.html.twig', [
            'lieux' => $lieux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lieux_show", methods={"GET"})
     */
    public function show(Lieux $lieux): Response
    {
        return $this->render('lieux/show.html.twig', [
            'lieux' => $lieux,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lieux_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lieux $lieux): Response
    {
        $form = $this->createForm(LieuxType::class, $lieux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lieux->setUpdatedAt($this->test35());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lieux_index', [
                'id' => $lieux->getId(),
            ]);
        }

        return $this->render('lieux/edit.html.twig', [
            'lieux' => $lieux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lieux_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lieux $lieux): Response
    {
        $gareA = $this->getDoctrine()->getRepository(Trajet::class)->findOneBy([
            'arrivee' => $lieux
        ]);
        $gareD = $this->getDoctrine()->getRepository(Trajet::class)->findOneBy([
            'depart' => $lieux
        ]);
        $gareG = $this->getDoctrine()->getRepository(Guichet::class)->findOneBy([
            'lieu' => $lieux
        ]);
        if($gareA || $gareD)
        {
            return $this->render('lieux/show.html.twig', [
            'lieux' => $lieux,
            'error' => "Il y'a une contrainte d'integrité entre 'Gare' et 'Trajet'"
        ]);
        }


        if($gareG)
        {
            return $this->render('lieux/show.html.twig', [
            'lieux' => $lieux,
            'erreur' => "Il y'a une contrainte d'integrité entre 'Gare' et 'Guichet'"
        ]);
        }
        if ($this->isCsrfTokenValid('delete'.$lieux->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lieux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lieux_index');
    }

    
}
