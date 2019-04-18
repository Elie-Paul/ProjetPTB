<?php

namespace App\Controller;

use App\Entity\Destinateur;
use App\Entity\User;
use App\Form\UserType;
use App\Controller\MailController;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/bloquer", name="user_bloquer", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function bloquer(Request $request): Response
    {
        if($request->isXmlHttpRequest())
        {
            $id = $_POST['id'];
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);
            if($user)
            {
                if($user->getActive())
                {
                    $user->setActive(false);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    return new JsonResponse([
                        'status' => 'success',
                        'message' => "L'utilisateur est bloqué"
                    ]);
                }
                else
                {
                    $user->setActive(true);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    return new JsonResponse([
                        'status' => 'success',
                        'message' => "L'utilisateur est activé"
                    ]);
                }
            }
            return new JsonResponse([
                'status' => 'error',
                'message' => "L'utilisateur n'existe pas"
            ]);
        }
    }


    /**
     * @Route("/mail", name="user_mail", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function mail(UserRepository $userRepository): Response
    {
        return $this->render('user/usermail.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param MailController $mail
     * @param UserRepository $userRepository
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request,UserPasswordEncoderInterface $encoder, MailController $mail, UserRepository $userRepository): Response
    {
        $user = new User();
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

            $user1 = $userRepository->findOneBy([
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
            ]);
            if (!$user1)
            {
                $mail->sendMailUserInfo($user->getNom(),$user->getPrenom(), $user->getEmail(), $user->getRoles());
                $mail->sendMailToUser($user->getUsername(), $user->getPassword(), $user->getNom(), $user->getPrenom(), $user->getEmail(), $user->getRoles(), 'mail/index.html.twig');
                $user->setCreatedAt($this->test35());
                $user->setUpdateAt($this->test35());
                $user->setFilename("null");
                $hash=$encoder->encodePassword($user, $user->getPassword()); 
                $user->setPassword($hash);           
                $entityManager = $this->getDoctrine()->getManager();           
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->render('user/index.html.twig', [
                    'users' => $userRepository->findAll(),
                    'success' => 'L\'utilisateur  '.$user->getNom().' '.$user->getPrenom().' a été créer',
                ]);
            }
            else
            {
                return $this->render('user/new.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                    'error' => 'L\'utilisateur '.$user->getNom().' '.$user->getPrenom().' existe déjà',
                ]);
            }
            
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(Request $request, User $user): Response
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
            $user->setUpdateAt($this->test35());
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'id' => $user->getId(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws \Exception
     */
    public function edit(Request $request, User $user,UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createFormBuilder($user)    
        ->add('nom')            
        ->add('prenom')
        ->add('email')
        ->add('username',TextType::class,[
            'required' => true,
            'label'=> "Utilisateur"          
        ])
        ->add('roles', ChoiceType::class, [
            'choices' => [                    
                'Billetteur' => 'ROLE_BILLETTEUR',
                'Validateur' => 'ROLE_VALIDATEUR',
                'Administrateur' => 'ROLE_ADMINISTRATEUR',
                'Superviseur' => 'ROLE_SUPERVISEUR',
                'Responsable de Vente' => 'ROLE_RESPONSABLE_DE_VENTE',
            ],
            'label'=> "Rôles",
            'expanded' => false,
            'multiple' => true
        ])
        ->add('password',PasswordType::class,[
            'label'=> "Mot de Passe",
            
        ])        
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdateAt($this->test35());
            $hash=$encoder->encodePassword($user, $user->getPassword());  
            $user->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();            
            return $this->redirectToRoute('user_index', [
                'id' => $user->getId(),
            ]);
        }
            

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    public function totalBillet2()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findAll();
        $nuser=count($user);
       return $nuser;
    } 


    /**
     * @Route("/{id}/modifier", name="user_modifier", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws \Exception
     */
    public function modifier(Request $request, User $user,UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createFormBuilder($user)
        ->add('nom')            
        ->add('prenom')
        ->add('password',PasswordType::class,[
            'label'=> "Mot de Passe",
            
        ])        
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {            
            $user->setUpdateAt($this->test35());
            $hash=$encoder->encodePassword($user, $user->getPassword());  
            $user->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();            
            return $this->redirectToRoute('user_index', [
                'id' => $user->getId(),
            ]);
        }
            

        return $this->render('user/modification.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
    

 /**
  * Require ROLE_ADMINISTRATEUR for *every* controller method in this class.
  *
  * @IsGranted("ROLE_ADMINISTRATEUR")
  */
  public function adminDashboard()
{
    $this->denyAccessUnlessGranted('ROLE_ADMINISTRATEUR');

    // or add an optional message - seen by developers
    $this->denyAccessUnlessGranted('ROLE_ADMINISTRATEUR', null, 'User tried to access a page without having ROLE_ADMINISTRATEUR');
}
/**
  * Require ROLE_BILLETTEUR for *every* controller method in this class.
  *
  * @IsGranted("ROLE_BILLETTEUR")
  */
  public function billetteurDashboard()
{
    $this->denyAccessUnlessGranted('ROLE_BILLETTEUR');

    // or add an optional message - seen by developers
    $this->denyAccessUnlessGranted('ROLE_BILLETTEUR', null, 'User tried to access a page without having ROLE_BILLETTEUR');
}



/**
  * Require ROLE_VALIDATEUR for *every* controller method in this class.
  *
  * @IsGranted("ROLE_VALIDATEUR")
  */
  public function validateurDashboard()
{
    $this->denyAccessUnlessGranted('ROLE_VALIDATEUR');

    // or add an optional message - seen by developers
    $this->denyAccessUnlessGranted('ROLE_VALIDATEUR', null, 'User tried to access a page without having ROLE_VALIDATEUR');
}

/**
  * Require ROLE_SUPERVISEUR for *every* controller method in this class.
  *
  * @IsGranted("ROLE_SUPERVISEUR")
  */
  public function superviseurDashboard()
{
    $this->denyAccessUnlessGranted('ROLE_SUPERVISEUR');

    // or add an optional message - seen by developers
    $this->denyAccessUnlessGranted('ROLE_SUPERVISEUR', null, 'User tried to access a page without having ROLE_SUPERVISEUR');
}
}
