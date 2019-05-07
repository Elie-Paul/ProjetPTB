<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Navette;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/classe")
 */
class ClasseController extends AbstractController
{
    /**
     * @Route("/", name="classe_index", methods={"GET"})
     */
    public function index(ClasseRepository $classeRepository): Response
    {
        return $this->render('classe/index.html.twig', [
            'classes' => $classeRepository->findBy(array(), array('createdAt' => 'DESC')),
        ]);
    }

    /**
     * @Route("/new", name="classe_new", methods={"GET","POST"})
     */
    public function new(Request $request, ClasseRepository $classeRepository): Response
    {
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $classe1 = $classeRepository->findOneBy([
                'libelle' => $classe->getLibelle(),
            ]);

            if (!$classe1) {
                $classe->setCreatedAt($this->test35());
                $classe->setUpdatedAt($this->test35());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($classe);
                $entityManager->flush();

                //$this->addFlash('info','La classe '.$classe->getLibelle().' créée');

                return $this->render('classe/index.html.twig', [
                    'classes' => $classeRepository->findAll(),
                    'success' => 'La classe '.$classe->getLibelle().' créée',
                ]);
            }else{
                return $this->render('classe/new.html.twig', [
                    'classe' => $classe,
                    'form' => $form->createView(),
                    'error' => 'La classe '.$classe->getLibelle().' existe déjà',
                ]);
            }
            
        }

        return $this->render('classe/new.html.twig', [
            'classe' => $classe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classe_show", methods={"GET"})
     */
    public function show(Classe $classe): Response
    {
        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Classe $classe): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classe->setUpdatedAt($this->test35());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classe_index', [
                'id' => $classe->getId(),
            ]);
        }

        return $this->render('classe/edit.html.twig', [
            'classe' => $classe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Classe $classe): Response
    {
        $navette = $this->getDoctrine()->getRepository(navette::class)->findOneBy([
            'classe' => $classe
        ]);
        if($navette)
        {
            return $this->render('classe/show.html.twig', [
            'classe' => $classe,
            'error' => "Il y'a une contrainte d'integrité entre 'Classe' et 'Navette'"
        ]);
        }
        if ($this->isCsrfTokenValid('delete'.$classe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_index');
    }
}
