<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Controller\UserController;
use App\Repository\UserRepository;

use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Controller\TrajetController;
use App\Repository\TrajetRepository;

use App\Entity\Guichet;
use App\Form\GuichetType;
use App\Controller\GuichetController;
use App\Repository\GuichetRepository;
use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Controller\AbonnementController;
use App\Repository\AbonnementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(UserRepository $userRepository,GuichetRepository $guichetRep,AbonnementRepository $abonnementRep,TrajetRepository $trajetRep): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findAll();
        $nuser=count($user);

        $entityManagers = $this->getDoctrine()->getManager();
        $guic = $entityManagers->getRepository(Guichet::class)->findAll();
        $nguic=count($guic);

        $entityManagers = $this->getDoctrine()->getManager();
        $abon = $entityManagers->getRepository(Abonnement::class)->findAll();
        $nabon=count($abon);

        $entityManagers = $this->getDoctrine()->getManager();
        $tra = $entityManagers->getRepository(Trajet::class)->findAll();
        $ntra=count($tra);

        return $this->render('home/index.html.twig', [
            'users' => $userRepository->findAll(),'nbre'=>$nuser,'guichets' => $guichetRep->findAll(),'nbreguichet'=>$nguic,'abonnement' => $abonnementRep->findAll(),'nbreabon'=>$nabon,'trajet' => $trajetRep->findAll(),'nbretrajt'=>$ntra
        ]);
    }
}
