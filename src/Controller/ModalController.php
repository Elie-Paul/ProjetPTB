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
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/addClasse", name="lieux_addClasse")
     */
    public function addClasse(Request $request)
    {    
        $libelle = $request->getContent();
        $classe = new Classe();

        $classe->setLibelle($libelle);
        $classe->setCreatedAt(new \DateTime());
        $classe->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($classe);
        $entityManager->flush();

        return new Response("true");
        //return $this->redirectToRoute('navette_new');
    }

    /**
     * @Route("/addLieuTrajet/{libelle}", name="lieux_addTLieurajet")
     */
    public function addLieuTrajet($libelle)
    {        
        $lieux = new Lieux();

        $lieux->setLibelle($libelle);
        $lieux->setCreatedAt(new \DateTime());
        $lieux->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return $this->redirectToRoute('trajet_new');
    }

    /**
     * @Route("/addLieuTrajetPtb/{libelle}", name="lieux_addTLieurajetPtb")
     */
    public function addLieuTrajetPtb($libelle)
    {        
        $lieux = new Lieux();

        $lieux->setLibelle($libelle);
        $lieux->setCreatedAt(new \DateTime());
        $lieux->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return $this->redirectToRoute('ptb_new');
    }

    /**
     * @Route("/addLieuTrajetNavette", name="lieux_addLieuTrajetNavette")
     */
    public function addLieuTrajetNavette(Request $request)
    {   
        $libelle = $request->getContent();
        $lieux = new Lieux();

        $lieux->setLibelle($libelle);
        $lieux->setCreatedAt(new \DateTime());
        $lieux->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return new Response("true");
        //return $this->redirectToRoute('navette_new');
    }

    /**
     * @Route("/addLieuGuichet/{libelle}", name="lieux_addGuichet")
     */
    public function addLieuGuichet($libelle)
    {        
        $lieux = new Lieux();
        $guichet = new Guichet();

        $lieux->setLibelle($libelle);
        $lieux->setCreatedAt(new \DateTime());
        $lieux->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->flush();

        return $this->redirectToRoute('guichet_new');
    }

    /**
     * @Route("/addSection", name="lieux_addSection")
     */
    public function addSection(Request $request)
    {   
        $array = explode("+",$request->getContent());
        $libelle = $array[0];
        $section = new Section();
        $prix = intval($array[1]);

        $section->setLibelle($libelle);
        $section->setPrix($prix);
        $section->setCreatedAt(new \DateTime());
        $section->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($section);
        $entityManager->flush();

        return new Response("true");
        //return $this->redirectToRoute('ptb_new');
    }

    /**
     * @Route("/addGuichetPtb", name="lieux_addGuichetPtb")
     */
    public function addGuichetPtb(Request $request)
    {        
        $array = explode("+",$request->getContent());

        $code = $array[0];
        $nom = $array[1];
        $lieu1 = $array[2];
        /*$lieux = $this->getDoctrine()->getRepository(Lieux::class)
            ->find(intval($array[2]));
        
        $lieu = $this->getDoctrine()->getRepository(Lieux::class)
            ->findOneBy([
                'id' => $lieux,
            ]);*/
        $guichet = new Guichet();
        $lieux = new Lieux();

        $guichet->setCode($code);
        $guichet->setNom($nom);
        $lieu = $lieux->setLibelle($lieu1);
        $guichet->setLieu($lieu);
        $guichet->setCreatedAt(new \DateTime());
        $guichet->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->persist($guichet);
        $entityManager->flush();

        return new Response("true");
        //return $this->redirectToRoute('billet_ptb_new');
    }

    /**
     * @Route("/addGuichetNavette/{code}/{nom}/{lieu}", name="lieux_addGuichetNavette")
     */
    public function addGuichetNavette($code, $nom, $lieu)
    {        
        $guichet = new Guichet();
        $lieux = new Lieux();

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

        return $this->redirectToRoute('billet_navette_new');
    }

    /**
     * @Route("/addNavetteBillet/{trajet}/{classe}/{prix}", name="lieux_addNavetteBillet")
     */
    public function addNavetteBillet($trajet, $classe, $prix)
    {        
        $navette = new Navette();
        $prix = intval($prix);

        $navette->setTrajet($trajet);
        $navette->setClasse($classe);
        $navette->setPrix($prix);
        $navette->setCreatedAt(new \DateTime());
        $navette->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($navette);
        $entityManager->flush();

        return $this->redirectToRoute('billet_navette_new');
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

        return $this->redirectToRoute('billet_ptb_new');
    }

    /**
     * @Route("/addTrajet/{depart}/{arrivee}", name="lieux_addTrajet")
     */
    public function addTrajet($depart, $arrivee)
    {        
        $trajet = new Trajet();
        $lieux = new Lieux();

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

        return $this->redirectToRoute('ptb_new');
    }

    /**
     * @Route("/addTrajetNavette", name="lieux_addTrajetNavette")
     */
    public function addTrajetNavette(Request $request)
    {   
        $array = explode("+",$request->getContent());
        $depart1 = $array[0];
        $arrivee1 = $array[1];
        $trajet = new Trajet();
        $lieux = new Lieux();

        $depart = $lieux->setLibelle($depart1);
        $arrivee = $lieux->setLibelle($arrivee1);


        $trajet->setDepart($depart);
        $trajet->setArrivee($arrivee);
        $trajet->setCreatedAt(new \DateTime());
        $trajet->setUpdatedAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lieux);
        $entityManager->persist($trajet);
        $entityManager->flush();

        return new Response("true");
       // return $this->redirectToRoute('navette_new');
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
     * @Route("/ModifierimageUser/{user}", name="img_ModiUser", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws \Exception
     */
    public function ModifierimageUser(Request $request, User $user): Response
    {        
        $form = $this->createFormBuilder($user)
        ->add('imageFile', FileType::class, [                
            'label' => "Image",
            'attr' => [                    
                'class' => 'form-control',
                'required' => true                  
                ]             
        ])
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdateAt(new \DateTime());           
            $this->getDoctrine()->getManager()->flush();
            return $this->render('user/show.html.twig', [
                'user' => $user,
                'id' => $user->getId(),
                'form' => $form->createView()
            ]);
        }
        return $this->render('user/modificationimage.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


}
