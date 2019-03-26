<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Trajet;
use App\Entity\Type;
use App\Form\TypeType;
use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Form\TrajetType;
use App\Entity\Guichet;
use App\Form\GuichetType;
use App\Repository\AbonnementRepository;
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
     * @Route("/addLieuTrajet/{libelle}", name="lieux_addTrajet")
     */
    public function addLieuTrajet($libelle)
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

    /**
     * @Route("/addLieuGuichet/{libelle}", name="lieux_addGuichet")
     */
    public function addLieuGuichet($libelle)
    {        
        $lieux = new Lieux();
        $guichet = new Guichet();
        $form = $this->createForm(GuichetType::class, $guichet);

        $lieux->setLibelle($libelle);
        $lieux->setCreatedAt(new \DateTime());
        $lieux->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return $this->render('guichet/new.html.twig', [
            'guichet' => $guichet,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/addTypeAbonne/{libelle}/{section}/{prix}", name="type_addAbonne")
     */
    public function addTypeAbonne($libelle,$section,$prix)
    {        
        $lieux = new Type();
        $guichet = new Abonnement();
        $form = $this->createForm(AbonnementType::class, $guichet);

        $lieux->setLibelle($libelle);
        $lieux->setPrix($prix);
        $lieux->setSection($section);        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return $this->render('abonnement/new.html.twig', [
            'abonnement' => $guichet,
            'form' => $form->createView(),
        ]);
    }
}
