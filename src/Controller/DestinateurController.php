<?php

namespace App\Controller;

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
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @Route("/destinateur/find/all/user", name="allUsers")
     */
    public function allUsers(Request $request, UserRepository $userRepository)
    {
        if($request->isXmlHttpRequest())
        {
            return new JsonResponse([
                'status' => 'success',
                'message' => 'ok',
                'utilisateur' => $userRepository->findAll()
            ]);
        }
    }
}
