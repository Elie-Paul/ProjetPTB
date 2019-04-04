<?php

namespace App\Controller;

use App\Entity\BilletPtb;
use App\Form\BilletPtbType;
use App\Repository\BilletPtbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/billet/ptb")
 */
class BilletPtbController extends AbstractController
{
    /**
     * @Route("/", name="billet_ptb_index", methods={"GET"})
     * @param BilletPtbRepository $billetPtbRepository
     * @return Response
     */
    public function index(BilletPtbRepository $billetPtbRepository, \Swift_Mailer $mailer, Request $request): Response
    {
           /* $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                ->setReplyTo('napalousmanadda@gmail.com')
                ->setBody($this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/test.html.twig'
                ),
                'text/html');
        
            $mailer->send($message);*/
        

        return $this->render('billet_ptb/index.html.twig', [
            'billet_ptbs' => $billetPtbRepository->findAll(),
        ]);
    }

    /**
     * @Route("/index2", name="billet_ptb_index2", methods={"GET"})
     * @param BilletPtbRepository $billetPtbRepository
     * @return Response
     */
    public function index2(BilletPtbRepository $billetPtbRepository, \Swift_Mailer $mailer, Request $request): Response
    {
        $billetPtb = new BilletPtb();

        /*$billetPtb = $billetPtbRepository->findBy([
            'createdAt' => 'DESC',
        ]);*/
        return $this->render('billet_ptb/index2.html.twig', [
            'billet_ptbs' => $billetPtbRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="billet_ptb_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request, BilletPtbRepository $billetPtbRepository): Response
    {
        $billetPtb = new BilletPtb();
        $form = $this->createForm(BilletPtbType::class, $billetPtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $billetPtb1 = $billetPtbRepository->findOneBy([
                'guichet' => $billetPtb->getGuichet(),
                'ptb' => $billetPtb->getPtb()
            ]);

            if (!$billetPtb1) {
                $billetPtb->setNumeroDernierBillets(0);
                $billetPtb->setCreatedAt(new \DateTime());
                $billetPtb->setUpdateAt(new \DateTime());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($billetPtb);
                $entityManager->flush();

             //$this->addFlash('info','Le train PTB '.$billetPtb->getPtb().' a été créer');

                return $this->render('billet_ptb/index2.html.twig', [
                    'billet_ptbs' => $billetPtbRepository->findAll(),
                    'success' => 'Le train PTB '.$billetPtb->getPtb().' a été créer',
                ]);
            }else {
                return $this->render('billet_ptb/new.html.twig', [
                    'billet_ptb' => $billetPtb,
                    'form' => $form->createView(),
                    'error' => 'Le train PTB '.$billetPtb->getPtb().' existe déjà',
                ]);
            }
            
        }

        return $this->render('billet_ptb/new.html.twig', [
            'billet_ptb' => $billetPtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_ptb_show", methods={"GET"})
     * @param BilletPtb $billetPtb
     * @return Response
     */
    public function show(BilletPtb $billetPtb): Response
    {
        return $this->render('billet_ptb/show.html.twig', [
            'billet_ptb' => $billetPtb,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="billet_ptb_edit", methods={"GET","POST"})
     * @param Request $request
     * @param BilletPtb $billetPtb
     * @return Response
     */
    public function edit(Request $request, BilletPtb $billetPtb): Response
    {
        $form = $this->createForm(BilletPtbType::class, $billetPtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $billetPtb->setUpdateAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('billet_ptb_index', [
                'id' => $billetPtb->getId(),
            ]);
        }

        return $this->render('billet_ptb/edit.html.twig', [
            'billet_ptb' => $billetPtb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_ptb_delete", methods={"DELETE"})
     * @param Request $request
     * @param BilletPtb $billetPtb
     * @return Response
     */
    public function delete(Request $request, BilletPtb $billetPtb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$billetPtb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($billetPtb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('billet_ptb_index');
    }
}
