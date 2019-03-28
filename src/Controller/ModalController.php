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
use App\Entity\Section;
use App\Entity\Ptb;
use App\Form\PtbType;
use App\Entity\Classe;
use App\Entity\Navette;
use App\Form\NavetteType;

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
     * @Route("/addClasse/{libelle}", name="lieux_addClasse")
     */
    public function addClasse($libelle)
    {    
        $classe = new Classe();
        $navette = new Navette();
        $form = $this->createForm(NavetteType::class, $navette);

        $classe->setLibelle($libelle);
        $classe->setCreatedAt(new \DateTime());
        $classe->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($classe);
        $entityManager->flush();

        return $this->render('navette/new.html.twig', [
            'navette' => $navette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/addLieuTrajet/{libelle}", name="lieux_addTLieurajet")
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
    }

    /**
     * @Route("/addLieuTrajetPtb/{libelle}", name="lieux_addTLieurajetPtb")
     */
    public function addLieuTrajetPtb($libelle)
    {        
        $lieux = new Lieux();
        $ptb = new Ptb();
        $form = $this->createForm(PtbType::class, $ptb);

        $lieux->setLibelle($libelle);
        $lieux->setCreatedAt(new \DateTime());
        $lieux->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return $this->render('ptb/new.html.twig', [
            'ptb' => $ptb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/addLieuTrajetNavette/{libelle}", name="lieux_addLieuTrajetNavette")
     */
    public function addLieuTrajetNavette($libelle)
    {        
        $lieux = new Lieux();
        $navette = new Navette();
        $form = $this->createForm(NavetteType::class, $navette);

        $lieux->setLibelle($libelle);
        $lieux->setCreatedAt(new \DateTime());
        $lieux->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return $this->render('navette/new.html.twig', [
            'navette' => $navette,
            'form' => $form->createView(),
        ]);
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
     * @Route("/addSection/{libelle}/{prix}", name="lieux_addSection")
     */
    public function addSection($libelle, $prix)
    {        
        $section = new Section();
        $prix = intval($prix);
        $ptb = new Ptb();
        $form = $this->createForm(PtbType::class, $ptb);

        $section->setLibelle($libelle);
        $section->setPrix($prix);
        $section->setCreatedAt(new \DateTime());
        $section->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($section);
        $entityManager->flush();

        return $this->render('ptb/new.html.twig', [
            'ptb' => $ptb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/addTrajet/{depart}/{arrivee}", name="lieux_addTrajet")
     */
    public function addTrajet($depart, $arrivee)
    {        
        $trajet = new Trajet();
        $lieux = new Lieux();
        $ptb = new Ptb();
        $form = $this->createForm(PtbType::class, $ptb);

        $depart = $lieux->setLibelle($depart);
        $arrivee = $lieux->setLibelle($arrivee);


        $trajet->setDepart($depart);
        $trajet->setArrivee($arrivee);
        $trajet->setCreatedAt(new \DateTime());
        $trajet->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->persist($trajet);
        $entityManager->flush();

        return $this->render('ptb/new.html.twig', [
            'ptb' => $ptb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/addTrajetNavette/{depart}/{arrivee}", name="lieux_addTrajetNavette")
     */
    public function addTrajetNavette($depart, $arrivee)
    {        
        $trajet = new Trajet();
        $lieux = new Lieux();
        $navette = new Navette();
        $form = $this->createForm(NavetteType::class, $navette);

        $depart = $lieux->setLibelle($depart);
        $arrivee = $lieux->setLibelle($arrivee);


        $trajet->setDepart($depart);
        $trajet->setArrivee($arrivee);
        $trajet->setCreatedAt(new \DateTime());
        $trajet->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->persist($trajet);
        $entityManager->flush();

        return $this->render('navette/new.html.twig', [
            'navette' => $navette,
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
