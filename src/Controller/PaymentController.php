<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/", name="payment_index", methods={"GET"})
     * @param PaymentRepository $paymentRepository
     * @return Response
     */
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="payment_new", methods={"GET","POST"})
     * @param Request $request
     * @param PaymentRepository $repo
     * @return Response
     */
    public function new(Request $request, PaymentRepository $repo): Response
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);
        $payment->setAnnee(\date('Y'));
        $entityManager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
             $payRepo = $repo;
             if($payRepo->findByMois($payment->getMois()))
             {
                 return $this->render('payment/new.html.twig', [
                     'payment' => $payment,
                     'error' => 'Erreur ! Le mois selectionné est deja payé',
                     'form' => $form->createView(),
                 ]);
             }
            if (!$payment->getAbonnement()) {
                return $this->render('payment/new.html.twig', [
                    'payment' => $payment,
                    'error' => 'Erreur ! Il faut selectionner un abonnement',
                    'form' => $form->createView(),
                ]);
            }
            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('payment_index');
        }

        return $this->render('payment/new.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_show", methods={"GET"})
     * @param Payment $payment
     * @return Response
     */
    public function show(Payment $payment): Response
    {
        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payment_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Payment $payment
     * @param PaymentRepository $repo
     * @return Response
     */
    public function edit(Request $request, Payment $payment, PaymentRepository $repo): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pay = $repo->findByMois($payment->getMois());
            if($pay[0]->getAnnee() === $payment->getAnnee())
            {
                return $this->render('payment/edit.html.twig', [
                    'payment' => $payment,
                    'error' => 'Erreur ! Le mois selectionné est deja payé',
                    'form' => $form->createView(),
                ]);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_index', [
                'id' => $payment->getId(),
            ]);
        }

        return $this->render('payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_delete", methods={"DELETE"})
     * @param Request $request
     * @param Payment $payment
     * @return Response
     */
    public function delete(Request $request, Payment $payment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $payment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($payment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_index');
    }
}
