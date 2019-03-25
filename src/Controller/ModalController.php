<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Repository\TrajetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ModalController extends AbstractController
{
    /**
     * @Route("/modal", name="modal")
     */
    public function index()
    {
        return $this->render('modal/index.html.twig', [
            'controller_name' => 'ModalController',
        ]);
    }

    /**
     * @Route("/add/{libelle}", name="lieux_add")
     */
    public function add($libelle)
    {        
        $lieux = new Lieux();
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);

        $lieux->setLibelle($libelle);
        $lieux->setCreatedAt(new \DateTime());
        $lieux->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return $this->render('trajet/new.html.twig', [
            'trajet' => $trajet,
            'form' => $form->createView(),
        ]);
        //return new Response('/trajet');
    }
}
