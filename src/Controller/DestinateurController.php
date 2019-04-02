<?php

namespace App\Controller;

use App\Entity\Destinateur;
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
     * @return Response
     */
    public function index(UserRepository $userRepository)
    {
        return $this->render('destinateur/index.html.twig', [
            'controller_name' => 'DestinateurController',
            'utilisateur' => $userRepository->findAll()
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
            $destinateur = new Destinateur();
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
                $destinateur->setEmail($email);
                $destinateur->setNom($nom);
                $destinateur->setPrenom($prenom);
                $destinateur->setProcessus('utilisateur');
                $manager->persist($destinateur);
                $manager->flush();
                return new JsonResponse([
                    'status' => 'success',
                    'message' => 'Les emails ont été ajouté',
                    'user' => $email
                ]);
            }
            else
            {
                $tab = explode(",", $dataUser[0]);
                foreach ($tab as $user)
                {
                    $vals = explode(" ", $user);
                    $nom = $vals[0];
                    $prenom = $vals[1];
                    $email = $vals[2];
                    $destinateur->setProcessus('utilisateur');
                    $destinateur->setEmail($email);
                    $destinateur->setNom($nom);
                    $destinateur->setPrenom($prenom);
                    $manager->persist($destinateur);
                    $manager->flush();
                }
                return new JsonResponse([
                    'status' => 'success',
                    'message' => 'Les emails ont été ajouté'
                ]);
            }
        }
    }
}
