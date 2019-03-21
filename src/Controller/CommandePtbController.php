<?php

namespace App\Controller;

use App\Entity\CommandePtb;
use App\Form\CommandePtbType;
use App\Repository\CommandePtbRepository;
use App\Repository\GuichetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande/ptb")
 */
class CommandePtbController extends AbstractController
{
    /**
     * @Route("/", name="commande_ptb_index", methods={"GET"})
     */
    public function index(GuichetRepository $commandePtbRepository): Response
    {
        return $this->render('commande_ptb/index.html.twig', [
            'commande_ptbs' => $commandePtbRepository->findAll(),
        ]);
        //return new JsonResponse($commandePtbRepository->findAll());
        
    }

    /**
     * @Route("/new", name="commande_ptb_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
       /* $commandePtb = new CommandePtb();
        $form = $this->createForm(CommandePtbType::class, $commandePtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandePtb);
            $entityManager->flush();

            return $this->redirectToRoute('commande_ptb_index');
        }

        return $this->render('commande_ptb/new.html.twig', [
            'commande_ptb' => $commandePtb,
            'form' => $form->createView(),
        ]);*/
        return $this->render('commande_ptb/vvvv.html.twig');
    }

    /**
     * @Route("/{id}", name="commande_ptb_show", methods={"GET"})
     */
    public function show(CommandePtb $commandePtb): Response
    {
        return $this->render('commande_ptb/show.html.twig', [
            'commande_ptb' => $commandePtb,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_ptb_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandePtb $commandePtb): Response
    {
        $form = $this->createForm(CommandePtbType::class, $commandePtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_ptb_index', [
                'id' => $commandePtb->getId(),
            ]);
        }

        return $this->render('commande_ptb/edit.html.twig', [
            'commande_ptb' => $commandePtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_ptb_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandePtb $commandePtb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandePtb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandePtb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_ptb_index');
    }
}
