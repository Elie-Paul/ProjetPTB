<?php

namespace App\Controller;

use App\Entity\Vignette;
use App\Form\VignetteType;
use App\Repository\VignetteRepository;
use App\Controller\CommandeVignetteController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vignette")
 */
class VignetteController extends AbstractController
{
    /**
     * @Route("/", name="vignette_index", methods={"GET"})
     */
    public function index(VignetteRepository $vignetteRepository,Request $request,CommandeVignetteController $controller): Response
    {
        $array = array();
        foreach ($vignetteRepository->findAll() as $key => $value) 
        {
            $arr = array();
            $id = $value->getId();
            $total = intVal($controller->totalBillet2($id));
            $arr = ['billet' => $value,'total' => $total];
            array_push($array,$arr);
        }
    

    return $this->render('vignette/index.html.twig', [
        'vignettes' =>$array,
    ]);
    }

    /**
     * @Route("/new", name="vignette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vignette = new Vignette();
        $form = $this->createForm(VignetteType::class, $vignette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vignette);
            $entityManager->flush();

            return $this->redirectToRoute('vignette_index');
        }

        return $this->render('vignette/new.html.twig', [
            'vignette' => $vignette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vignette_show", methods={"GET"})
     */
    public function show(Vignette $vignette): Response
    {
        return $this->render('vignette/show.html.twig', [
            'vignette' => $vignette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vignette_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vignette $vignette): Response
    {
        $form = $this->createForm(VignetteType::class, $vignette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vignette_index', [
                'id' => $vignette->getId(),
            ]);
        }

        return $this->render('vignette/edit.html.twig', [
            'vignette' => $vignette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vignette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vignette $vignette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vignette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vignette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vignette_index');
    }
}
