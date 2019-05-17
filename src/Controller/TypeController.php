<?php

namespace App\Controller;

use App\Entity\Type;
use App\Entity\Abonnement;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="type_index", methods={"GET"})
     * @param TypeRepository $typeRepository
     * @return Response
     */
    public function index(TypeRepository $typeRepository): Response
    {
        return $this->render('type/index.html.twig', [
            'types' => $typeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->redirectToRoute('type_index');
        }

        return $this->render('type/new.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_show", methods={"GET"})
     * @param Type $type
     * @return Response
     */
    public function show(Type $type): Response
    {
        return $this->render('type/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Type $type
     * @return Response
     */
    public function edit(Request $request, Type $type): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_index', [
                'id' => $type->getId(),
            ]);
        }

        return $this->render('type/edit.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_delete", methods={"DELETE"})
     * @param Request $request
     * @param Type $type
     * @return Response
     */
    public function delete(Request $request, Type $type): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $abonne = $this->getDoctrine()->getRepository(Abonnement::class)->findOneBy([
            'type' => $type
            ]);
            if($abonne)
            {
                return $this->render('type/index.html.twig', [
            'types' => $this->getDoctrine()->getRepository(Type::class)->findAll(),
            'erreur' => "Il y'a une contrainte d'integrité entre 'Type' et 'Abonnement.'"
            ]);
            }
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_index');
    }
}
