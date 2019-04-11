<?php

namespace App\Controller;

use App\Entity\Destinateur;
use App\Repository\DestinateurRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DestinateurController extends AbstractController
{
    /**
     * @Route("/destinateur", name="destinateur")
     * @param UserRepository $userRepository
     * @param DestinateurRepository $destinateurRepository
     * @return Response
     */
    public function index(UserRepository $userRepository, DestinateurRepository $destinateurRepository)
    {
        return $this->render('destinateur/index.html.twig', [
            'controller_name' => 'DestinateurController',
            'utilisateur' => $userRepository->findAll(),
            'destinateurs' => $destinateurRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/destinateur/bloquer", name="bloquer_destinateur")
     */
    public function bloquer(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $email = $_POST['email'];
            $processus = $_POST['processus'];
            $etat = null;
            $dest = $this->getDoctrine()->getRepository(Destinateur::class)->findOneBy([
                'email' => $email,
                'processus' => $processus
            ]);
            if($dest)
            {
                if($dest->getActive())
                {
                    $dest->setActive(false);
                    $etat = false;
                }
                else
                {
                    $dest->setActive(true);
                    $etat = true;
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($dest);
                $em->flush();
                $dest = null;
                $em->clear();
                if($etat)
                {
                    return new JsonResponse([
                        'status' => 'success',
                        'message' => "L'utilisateur est activé avec succès"
                    ]);
                }
                return new JsonResponse([
                    'status' => 'success',
                    'message' => "L'utilisateur est bloqué avec succès"
                ]);
            }
            return new JsonResponse([
                'status' => 'error',
                'message' => "Ooops! Un problème est survenu, l'utilisateur n'a pas été bloqué"
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/destinateur/supprimer", name="supprimer_destinateur")
     */
    public function supprimer(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $email = $_POST['email'];
            $dest = $this->getDoctrine()->getRepository(Destinateur::class)->findOneBy([
                'email' => $email
            ]);
            if ($dest) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($dest);
                $em->flush();
                $dest = null;
                $em->clear();
                return new JsonResponse([
                    'status' => 'success',
                    'message' => "L'utilisateur est supprimé avec succès"
                ]);
            }
            return new JsonResponse([
                'status' => 'error',
                'message' => "Ooops! Un problème est survenu, l'utilisateur n'a pas été bloqué"
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/destinateur/add/mail", name="addMail")
     */
    public function addMail(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $manager = $this->getDoctrine()->getManager();
            $destUser = new Destinateur();
            $destCmd = new Destinateur();
            $destImp = new Destinateur();
            if(!isset($_POST['user']) && !isset($_POST['commande']) && !isset($_POST['impression']) )
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Tous less champs sont vides'
                ]);
//            $impressions = $_POST['impression'];
//            $commandes = $_POST['commande'];
//            $users = $_POST['user'];
//            $dataUser = [];
//            $dataCommande = [];
//            $dataImpression = [];
//            foreach ($users as $user)
//            {
//                $dataUser[] = $user;
//            }
//            foreach ($commandes as $commande)
//            {
//                $dataCommande[] = $commande;
//            }
//            foreach ($impressions as $impression)
//            {
//                $dataImpression[] = $impression;
//            }
            if(isset($_POST['user']))
            {
                $users = $_POST['user'];
                $dataUser = [];
                foreach ($users as $user)
                {
                    $dataUser[] = $user;
                }
                if (count($dataUser) == 1)
                {
                    $user = explode(" ", $dataUser[0]);
                    $nom = $user[0];
                    $prenom = $user[1];
                    $email = $user[2];
                    $destUser->setEmail($email);
                    $destUser->setNom($nom);
                    $destUser->setPrenom($prenom);
                    $destUser->setActive(true);
                    $destUser->setProcessus('utilisateur');
                    $check = $this->getDoctrine()->getRepository(Destinateur::class)->findOneBy([
                        'email' => $destUser->getEmail(),
                        'processus' => $destUser->getProcessus()
                    ]);
                    if($check)
                    {
                        return new JsonResponse([
                            'status' => 'error',
                            'message' => "L'adresse email " . $destUser->getEmail() . " reçoit dejà un email pour le processus UTILISATEUR"
                        ]);
                    }
                    $manager->persist($destUser);
                }
                if (count($dataUser) != 1 && count($dataUser) > 0)
                {
                    $t = array();
                    foreach ($dataUser as $user) {
                        $vals = explode(" ", $user);
                        $nom = $vals[0];
                        $prenom = $vals[1];
                        $email = $vals[2];
                        $destinateur = new Destinateur();
                        $destinateur->setProcessus('utilisateur');
                        $destinateur->setEmail($email);
                        $destinateur->setNom($nom);
                        $destinateur->setPrenom($prenom);
                        $destinateur->setActive(true);
                        $check = $this->getDoctrine()->getRepository(Destinateur::class)->findOneBy([
                            'email' => $destinateur->getEmail(),
                            'processus' => $destinateur->getProcessus()
                        ]);
                        if($check)
                        {
                            return new JsonResponse([
                                'status' => 'error',
                                'message' => "L'adresse email " . $destinateur->getEmail() . " reçoit dejà un email pour le processus UTILISATEUR"
                            ]);
                        }
                        $t[] = $destinateur;

                    }
                    for ($i = 0; $i < count($t); $i++) {
                        $manager->persist($t[$i]);
                    }
                }
            }
            if(isset($_POST['commande']))
            {
                $commandes = $_POST['commande'];
                $dataCommande = [];
                foreach ($commandes as $commande)
                {
                    $dataCommande[] = $commande;
                }
                if (count($dataCommande) == 1)
                {
                    $user = explode(" ", $dataCommande[0]);
                    $nom = $user[0];
                    $prenom = $user[1];
                    $email = $user[2];
                    $destCmd->setEmail($email);
                    $destCmd->setNom($nom);
                    $destCmd->setPrenom($prenom);
                    $destCmd->setActive(true);
                    $destCmd->setProcessus('commande');
                    $check = $this->getDoctrine()->getRepository(Destinateur::class)->findOneBy([
                        'email' => $destCmd->getEmail(),
                        'processus' => $destCmd->getProcessus()
                    ]);
                    if($check)
                    {
                        return new JsonResponse([
                            'status' => 'error',
                            'message' => "L'adresse email " . $destCmd->getEmail() . " reçoit dejà un email pour le processus COMMANDE"
                        ]);
                    }
                    $manager->persist($destCmd);
                }
                if (count($dataCommande) != 1)
                {
                    $t = array();
                    foreach ($dataCommande as $user)
                    {
                        $vals = explode(" ", $user);
                        $nom = $vals[0];
                        $prenom = $vals[1];
                        $email = $vals[2];
                        $destinateur = new Destinateur();
                        $destinateur->setProcessus('commande');
                        $destinateur->setEmail($email);
                        $destinateur->setNom($nom);
                        $destinateur->setPrenom($prenom);
                        $destinateur->setActive(true);
                        $check = $this->getDoctrine()->getRepository(Destinateur::class)->findOneBy([
                            'email' => $destinateur->getEmail(),
                            'processus' => $destinateur->getProcessus()
                        ]);
                        if($check)
                        {
                            return new JsonResponse([
                                'status' => 'error',
                                'message' => "L'adresse email " . $destinateur->getEmail() . " reçoit dejà un email pour le processus COMMANDE"
                            ]);
                        }
                        $t[] = $destinateur;

                    }
                    for ($i = 0; $i < count($t); $i++)
                    {
                        $manager->persist($t[$i]);
                    }
                }
            }
            if(isset($_POST['impression']))
            {
                $impressions = $_POST['impression'];
                $dataImpression = [];
                foreach ($impressions as $impression)
                {
                    $dataImpression[] = $impression;
                }
                if (count($dataImpression) == 1) {
                    $user = explode(" ", $dataImpression[0]);
                    $nom = $user[0];
                    $prenom = $user[1];
                    $email = $user[2];
                    $destImp->setEmail($email);
                    $destImp->setNom($nom);
                    $destImp->setPrenom($prenom);
                    $destImp->setActive(true);
                    $destImp->setProcessus('impression');
                    $check = $this->getDoctrine()->getRepository(Destinateur::class)->findOneBy([
                        'email' => $destImp->getEmail(),
                        'processus' => $destImp->getProcessus()
                    ]);
                    if($check)
                    {
                        return new JsonResponse([
                            'status' => 'error',
                            'message' => "L'adresse email " . $destImp->getEmail() . " reçoit dejà un email pour le processus IMPRESSION"
                        ]);
                    }
                    $manager->persist($destImp);
                }
                if (count($dataImpression) != 1) {
                    $t = array();
                    foreach ($dataImpression as $user) {
                        $vals = explode(" ", $user);
                        $nom = $vals[0];
                        $prenom = $vals[1];
                        $email = $vals[2];
                        $destinateur = new Destinateur();
                        $destinateur->setProcessus('impression');
                        $destinateur->setEmail($email);
                        $destinateur->setNom($nom);
                        $destinateur->setPrenom($prenom);
                        $destinateur->setActive(true);
                        $check = $this->getDoctrine()->getRepository(Destinateur::class)->findOneBy([
                            'email' => $destinateur->getEmail(),
                            'processus' => $destinateur->getProcessus()
                        ]);
                        if($check)
                        {
                            return new JsonResponse([
                                'status' => 'error',
                                'message' => "L'adresse email " . $destinateur->getEmail() . " reçoit dejà un email pour le processus IMPRESSION"
                            ]);
                        }
                        $t[] = $destinateur;

                    }
                    for ($i = 0; $i < count($t); $i++) {
                        $manager->persist($t[$i]);
                    }
                }
            }
            $manager->flush();
            return new JsonResponse([
                'status' => 'success',
                'message' => 'Les emails ont été ajouté'
            ]);
        }
    }
}
