<?php

namespace App\Controller;

use App\Entity\BilletPtb;
use App\Entity\VentePtb;
use App\Entity\Guichet;
use App\Entity\CommandePtb;
use App\Entity\Ptb;
use App\Form\BilletPtbType;
use App\Entity\StockPtb;
use App\Controller\JsonController\Controller;
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
    public function index(BilletPtbRepository $billetPtbRepository, \Swift_Mailer $mailer, Request $request,Controller $controller): Response
    {
         
            $array = array();
            foreach ($billetPtbRepository->findAll() as $key => $value) 
            {
                if($value->getEvenement() ==null)
                {    
                    $arr = array();
                    $id = $value->getId();
                    $total = intVal($controller->totalBillet2($id));
                    $arr = ['billet' => $value,'total' => $total];
                    array_push($array,$arr);
                }
            }
        

        return $this->render('billet_ptb/index.html.twig', [
            'billet_ptbs' =>$array,
        ]);
    }

    /**
     * @Route("/index2", name="billet_ptb_index2", methods={"GET"})
     * @param BilletPtbRepository $billetPtbRepository
     * @return Response
     */
    public function index2(BilletPtbRepository $billetPtbRepository, Request $request): Response
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
        $stockPtb = new StockPtb();
        $form = $this->createForm(BilletPtbType::class, $billetPtb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $billetPtb1 = $billetPtbRepository->findOneBy([
                'guichet' => $billetPtb->getGuichet(),
                'ptb' => $billetPtb->getPtb()
                
            ]);

            if (!$billetPtb1) {
                $billetPtb->setNumeroDernierBillets(0);
                $billetPtb->setCreatedAt($this->test35());
                $billetPtb->setUpdateAt($this->test35());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($billetPtb);
                $stockPtb->setBillet($billetPtb);
                $stockPtb->setNbre(0);
                $stockPtb->setCreatedAt($this->test35());
                $stockPtb->setUpdatedAt($this->test35());
                $entityManager->persist($stockPtb);
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
            $billetPtb->setUpdateAt($this->test35());
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
        $ptb = $this->getDoctrine()->getRepository(Ptb::class)->findOneBy([
            'billetPtb' => $billetPtb
        ]);
        $commande = $this->getDoctrine()->getRepository(CommandePtb::class)->findOneBy([
            'billet' => $billetPtb
        ]);
        $vente = $this->getDoctrine()->getRepository(VentePtb::class)->findOneBy([
            'billet' => $billetPtb
        ]);
        if($ptb)
        {
            return $this->render('billet_ptb/show.html.twig', [
            'billet_ptb' => $billetPtb,
            'error' => "Il y'a une contrainte d'integrité entre 'PTB' et 'Billet PTB'"
        ]);
        }

        if($vente)
        {
            return $this->render('billet_ptb/show.html.twig', [
            'billet_ptb' => $billetPtb,
            'erreur' => "Il y'a une contrainte d'integrité entre 'Vente PTB' et 'Billet PTB'"
        ]);
        }

        if($commande)
        {
            return $this->render('billet_ptb/show.html.twig', [
            'billet_ptb' => $billetPtb,
            'errors' => "Il y'a une contrainte d'integrité entre 'Commande PTB' et 'Billet PTB'"
        ]);
        }
        if ($this->isCsrfTokenValid('delete'.$billetPtb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($billetPtb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('billet_ptb_index');
    }
}
