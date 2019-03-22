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
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) { 
            $user->setCreatedAt(new \DateTime());
            $user->setUpdateAt(new \DateTime());              
            $hash=$encoder->encodePassword($user, $user->getPassword()); 
            $user->setPassword($hash);           
            $entityManager = $this->getDoctrine()->getManager();           
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
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
        /*,
        'attr'=>[
            'disabled' => true
        ]*/
        ->add('roles', ChoiceType::class, [
            'choices' => [                    
                'utilisateur' => 'ROLE_USER',
                'Administrateur' => 'ROLE_ADMIN',
                'Superviseur' => 'ROLE_SUPER_ADMIN',
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
  * Require ROLE_ADMIN for *every* controller method in this class.
  *
  * @IsGranted("ROLE_ADMIN")
  */
  public function adminDashboard()
{
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    // or add an optional message - seen by developers
    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
}
}
