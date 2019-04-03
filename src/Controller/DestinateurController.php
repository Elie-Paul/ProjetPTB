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
            $impressions = $_POST['impression'];
            $commandes = $_POST['commande'];
            $users = $_POST['user'];
            $dataUser = [];
            $dataCommande = [];
            $dataImpression = [];
            foreach ($users as $user)
            {
                $dataUser[] = $user;
            }
            foreach ($commandes as $commande)
            {
                $dataCommande[] = $commande;
            }
            foreach ($impressions as $impression)
            {
                $dataImpression[] = $impression;
            }
            if(count($dataUser) == 1)
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
                $manager->persist($destUser);
            }
            if(count($dataCommande) == 1)
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
                $manager->persist($destCmd);
            }
            if(count($dataImpression) == 1)
            {
                $user = explode(" ", $dataImpression[0]);
                $nom = $user[0];
                $prenom = $user[1];
                $email = $user[2];
                $destImp->setEmail($email);
                $destImp->setNom($nom);
                $destImp->setPrenom($prenom);
                $destImp->setActive(true);
                $destImp->setProcessus('impression');
                $manager->persist($destImp);
            }
            if(count($dataUser) != 1 && count($dataUser) > 0)
            {
                $t = array();
                foreach ($dataUser as $user)
                {
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
                    $t[] = $destinateur;

                }
                for($i = 0; $i < count($t); $i++)
                {
                    $manager->persist($t[$i]);
                }
            }
            if(count($dataCommande) != 1)
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
                    $t[] = $destinateur;

                }
                for($i = 0; $i < count($t); $i++)
                {
                    $manager->persist($t[$i]);
                }
            }
            if(count($dataImpression) != 1 && count($dataUser) > 0)
            {
                $t = array();
                foreach ($dataImpression as $user)
                {
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
                    $t[] = $destinateur;

                }
                for($i = 0; $i < count($t); $i++)
                {
                    $manager->persist($t[$i]);
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
