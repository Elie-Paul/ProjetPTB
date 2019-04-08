<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Trajet;
use App\Entity\Type;
use App\Form\TypeType;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Form\TrajetType;
use App\Entity\Guichet;
use App\Form\BilletPtbType;
use App\Form\GuichetType;
use App\Repository\AbonnementRepository;
use App\Repository\TrajetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\Section;
use App\Entity\Ptb;
use App\Form\PtbType;
use App\Entity\Classe;
use App\Entity\Navette;
use App\Form\NavetteType;
use App\Entity\BilletPtb;
use App\Entity\BilletNavette;
use App\Form\BilletNavetteType;

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

        return $this->redirectToRoute('guichet_new');
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

        return $this->redirectToRoute('ptb_new');
    }

    /**
     * @Route("/addGuichetPtb/{code}/{nom}/{lieu}", name="lieux_addGuichetPtb")
     */
    public function addGuichetPtb($code, $nom, $lieu)
    {        
        $guichet = new Guichet();
        $billetPtb = new BilletPtb();
        $lieux = new Lieux();
        $form = $this->createForm(BilletPtbType::class, $billetPtb);

        $guichet->setCode($code);
        $guichet->setNom($nom);
        $lieu = $lieux->setLibelle($lieu);
        $guichet->setLieu($lieu);
        $guichet->setCreatedAt(new \DateTime());
        $guichet->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->persist($guichet);
        $entityManager->flush();

        /*return $this->render('billet_ptb/new.html.twig', [
            'billet_ptbs' => $billetPtb,
            'form' => $form->createView(),
        ]);*/
        return $this->redirectToRoute('billet_ptb_new');
    }

    /**
     * @Route("/addGuichetNavette/{code}/{nom}/{lieu}", name="lieux_addGuichetNavette")
     */
    public function addGuichetNavette($code, $nom, $lieu)
    {        
        $guichet = new Guichet();
        $billetnavette = new BilletNavette();
        $lieux = new Lieux();
        $form = $this->createForm(BilletNavetteType::class, $billetnavette);

        $guichet->setCode($code);
        $guichet->setNom($nom);
        $lieu = $lieux->setLibelle($lieu);
        $guichet->setLieu($lieu);
        $guichet->setCreatedAt(new \DateTime());
        $guichet->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->persist($guichet);
        $entityManager->flush();

        return $this->render('billet_navette/new.html.twig', [
            'billet_navettes' => $billetnavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/addNavetteBillet/{trajet}/{classe}/{prix}", name="lieux_addNavetteBillet")
     */
    public function addNavetteBillet($trajet, $classe, $prix)
    {        
        $navette = new Navette();
        $prix = intval($prix);
        $billetnavette = new BilletNavette();
        $form = $this->createForm(BilletNavetteType::class, $billetnavette);

        $navette->setTrajet($trajet);
        $navette->setClasse($classe);
        $navette->setPrix($prix);
        $navette->setCreatedAt(new \DateTime());
        $navette->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($navette);
        $entityManager->flush();

        return $this->render('billet_navette/new.html.twig', [
            'billet_navettes' => $billetnavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/addPtbBillet/{trajet}/{section}", name="lieux_addPtbBillet")
     */
    public function addPtbBillet($trajet, $section)
    {        
        $ptb = new Ptb();
        $billetPtb = new BilletPtb();
        $lieux = new Lieux();
        $trajets = new Trajet();
        $sections = new Section();
        $form = $this->createForm(BilletPtbType::class, $billetPtb);

        //$trajet =  $trajets->setDepart()

        $ptb->setTrajet($trajet);
        $ptb->setSection($section);
        $ptb->setCreatedAt(new \DateTime());
        $ptb->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($ptb);
        $entityManager->flush();

        return $this->render('billet_ptb/new.html.twig', [
            'billet_ptbs' => $billetPtb,
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

    /**
     * @Route("/{id}/ModifierimageUser/{libelle}", name="img_ModiUser", methods={"GET","POST"})
     */
    public function ModifierimageUser($libelle)
    {       
            $user=new User();
            $user->setFilename($libelle);
            $user->setUpdateAt(new \DateTime());           
            $this->getDoctrine()->getManager()->flush();            
            return $this->redirectToRoute('user_show', [
                'id' => $user->getId(),
            ]);
    }


}
