<?php

namespace App\Controller;

use App\Entity\Ptb;
use App\Entity\BilletPtb;
use App\Entity\Guichet;
use App\Form\PtbType;
use App\Repository\PtbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ptb")
 */
class PtbController extends AbstractController
{
    /**
     * @Route("/", name="ptb_index", methods={"GET"})
     */
    public function index(PtbRepository $ptbRepository): Response
    {
        return $this->render('ptb/index.html.twig', [
            'ptbs' => $ptbRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ptb_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ptb = new Ptb();
        $billetPTB = new BilletPtb();
        $repository = $this->getDoctrine()->getRepository(Guichet::class);
        $form = $this->createForm(PtbType::class, $ptb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ptb->setCreatedAt(new \DateTime());
            $ptb->setUpdatedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ptb);
            $guichet = $repository->findOneBy(['lieu'=>$ptb->getTrajet()->getDepart()]);
            $billetPTB->setPtb($ptb);
            $billetPTB->setGuichet($guichet);
            $billetPTB->setNumeroDernierBillets(0);
            $billetPTB->setCreatedAt(new \DateTime());
            $billetPTB->setUpdateAt(new \DateTime());
            $entityManager->persist($billetPTB);
            $entityManager->flush();

            /// Message de confirmation
            $this->addFlash('success','Le train Ptb ayant le trajet '.$ptb->getTrajet().' et de '.$ptb->getSection()->getLibelle().' a été créer');
            return $this->redirectToRoute('ptb_index');
        }

        return $this->render('ptb/new.html.twig', [
            'ptb' => $ptb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ptb_show", methods={"GET"})
     */
    public function show(Ptb $ptb): Response
    {
        return $this->render('ptb/show.html.twig', [
            'ptb' => $ptb,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ptb_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ptb $ptb): Response
    {
        $form = $this->createForm(PtbType::class, $ptb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ptb->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ptb_index', [
                'id' => $ptb->getId(),
            ]);
        }

        return $this->render('ptb/edit.html.twig', [
            'ptb' => $ptb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ptb_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ptb $ptb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ptb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ptb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ptb_index');
    }
}
