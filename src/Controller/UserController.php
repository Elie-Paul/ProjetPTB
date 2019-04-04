<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    /**
     * @Route("/mail", name="user_mail", methods={"GET"})
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
            $user2 = $userRepository->findOneBy([
                'email' => $user->getEmail(),
            ]); 

            if (!$user1 && $user2) {
                $mail->sendMail("Elie-Paul");
                $user->setCreatedAt(new \DateTime());
                $user->setUpdateAt(new \DateTime());
                $user->setFilename("null");
                $hash=$encoder->encodePassword($user, $user->getPassword()); 
                $user->setPassword($hash);           
                $entityManager = $this->getDoctrine()->getManager();           
                $entityManager->persist($user);
                $entityManager->flush();

                /// Message de confirmation
                //$this->addFlash('success','L\'utilisateur '.$user->getNom().' '.$user->getPrenom().' a été créer');

                return $this->render('user/index.html.twig', [
                    'users' => $userRepository->findAll(),
                    'success' => 'L\'utilisateur  '.$user->getNom().' '.$user->getPrenom().' a été créer',
                ]);
            }else {
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
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user,UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createFormBuilder($user)
        ->add('imageFile', FileType::class, [                
            'label' => "Image",
            'attr' => [                    
                'class' => 'form-control',
                'required' => true                  
                ]             
        ])
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
            $user->setCreatedAt(new \DateTime());
            $user->setUpdateAt(new \DateTime());
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


      /**
     * @Route("/{id}/modifier", name="user_modifier", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function modifier(Request $request, User $user,UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createFormBuilder($user)
        ->add('nom')            
        ->add('prenom')
        ->add('email')
        ->add('password',PasswordType::class,[
            'label'=> "Mot de Passe",
            
        ])        
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {            
            $user->setUpdateAt(new \DateTime());
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
