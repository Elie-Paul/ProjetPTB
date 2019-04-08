<?php

namespace App\Controller;

use App\Entity\Navette;
use App\Entity\BilletNavette;
use App\Entity\Guichet;
use App\Form\NavetteType;
use App\Repository\NavetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/navette")
 */
class NavetteController extends AbstractController
{
    /**
     * @Route("/", name="navette_index", methods={"GET"})
     */
    public function index(NavetteRepository $navetteRepository): Response
    {
        return $this->render('navette/index.html.twig', [
            'navettes' => $navetteRepository->findBy(array(), array('createdAt' => 'DESC')),
        ]);
    }

    /**
     * @Route("/new", name="navette_new", methods={"GET","POST"})
     */
    public function new(Request $request, NavetteRepository $navetteRepository): Response
    {
        $navette = new Navette();
        $form = $this->createForm(NavetteType::class, $navette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $navette1 = $navetteRepository->findOneBy([
                'trajet' => $navette->getTrajet(),
                'classe' => $navette->getClasse()
            ]);

            if (!$navette1) {
                $navette->setCreatedAt(new \DateTime());
                $navette->setUpdatedAt(new \DateTime());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($navette);            
                $entityManager->flush();
                //$this->addFlash('info','Le train Autorail ayant le trajet '.$navette->getTrajet().' et de '.$navette->getClasse()->getLibelle().' a été créer');
                return $this->render('navette/index.html.twig', [
                    'navettes' => $navetteRepository->findAll(),
                    'success' => 'Le train Autorail ayant le trajet '.$navette->getTrajet().' et de '.$navette->getClasse()->getLibelle().' a été créer',
                ]);
            }else{
                return $this->render('navette/new.html.twig', [
                    'navette' => $navette,
                    'error' => 'Le train Autorail ayant le trajet '.$navette->getTrajet().' et de '.$navette->getClasse()->getLibelle().' existe déjà',
                    'form' => $form->createView(),
                ]);
            }
            

            
        }

        return $this->render('navette/new.html.twig', [
            'navette' => $navette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="navette_show", methods={"GET"})
     */
    public function show(Navette $navette): Response
    {
        return $this->render('navette/show.html.twig', [
            'navette' => $navette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="navette_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Navette $navette): Response
    {
        $form = $this->createForm(NavetteType::class, $navette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $navette->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('navette_index', [
                'id' => $navette->getId(),
            ]);
        }

        return $this->render('navette/edit.html.twig', [
            'navette' => $navette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="navette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Navette $navette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$navette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($navette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('navette_index');
    }
}
