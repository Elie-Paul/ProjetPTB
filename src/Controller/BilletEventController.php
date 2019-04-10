<?php

namespace App\Controller;

use App\Entity\BilletEvent;
use App\Form\BilletEventType;
use App\Repository\BilletEventRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\BilletPtb;
use App\Entity\Ptb;
use App\Entity\Guichet;
use App\Entity\Evenement;
use App\Form\BilletPtbType;
use App\Entity\StockPtb;
use App\Controller\JsonController\Controller;
use App\Repository\BilletPtbRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/billet/event")
 */
class BilletEventController extends AbstractController
{
    /**
     * @Route("/", name="billet_event_index", methods={"GET","POST"})
     * @param Request $request
     * @param BilletEventRepository $billetEventRepository
     * @return Response
     */
    public function index(BilletPtbRepository $billetPtbRepository, \Swift_Mailer $mailer, Request $request,Controller $controller): Response
    {
        $array = array();
        foreach ($billetPtbRepository->findAll() as $key => $value) 
        {
            if($value->getEvenement() != null)
            {
                $arr = array();
                $id = $value->getId();
                $total = intVal($controller->totalBillet2($id));
                $arr = ['billet' => $value,'total' => $total];
                array_push($array,$arr);
            } 
        }
    

        return $this->render('billet_event/index.html.twig', [
            'billet_ptbs' =>$array,
        ]);
    }

    /**
     * @Route("/new", name="billet_event_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request,BilletPtbRepository $billetPtbRepository): Response
    {
        $billetPtb = new BilletPtb();
        $stockPtb = new StockPtb();
        $form = $this->createFormBuilder($billetPtb)
        ->add('ptb', EntityType::class, [
            'class' => Ptb::class,
            
        ])
        ->add('guichet', EntityType::class, [
            'class' => Guichet::class,
            'choice_label' => 'nom'
        ])
        ->add('evenement', EntityType::class, [
            'class' => Evenement::class,
            'choice_label' => 'libelle'
        ])
        ->getForm();

        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $billetPtb1 = $billetPtbRepository->findOneBy([
                'guichet' => $billetPtb->getGuichet(),
                'ptb' => $billetPtb->getPtb(),
                'evenement' => $billetPtb->getEvenement()
                
            ]);

            if (!$billetPtb1) 
            {
                $billetPtb->setNumeroDernierBillets(0);
                $billetPtb->setCreatedAt(new \DateTime());
                $billetPtb->setUpdateAt(new \DateTime());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($billetPtb);
                $stockPtb->setBillet($billetPtb);
                $stockPtb->setNbre(0);
                $stockPtb->setCreatedAt(new \DateTime());
                $stockPtb->setUpdatedAt(new \DateTime());
                $entityManager->persist($stockPtb);
                $entityManager->flush();

             //$this->addFlash('info','Le train PTB '.findAll$billetPtb->getPtb().' a été créer');

             return $this->redirectToRoute('billet_event_index');
            }
            else 
            {
                return $this->render('billet_event/new.html.twig', [
                    'billet_ptb' => $billetPtb,
                    'form' => $form->createView(),
                    'error' => 'Le train PTB '.$billetPtb->getPtb().' existe déjà',
                ]);
            }
            
        }

        return $this->render('billet_event/new.html.twig', [
            'billet_ptb' => $billetPtb,
            'form' => $form->createView(),
            
        ]);
    }

}
