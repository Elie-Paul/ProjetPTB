<?php

namespace App\Controller;

use App\Entity\Guichet;
use App\Entity\BilletPtb;
use App\Entity\BilletNavette;
use App\Form\GuichetType;
use App\Entity\Lieux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\GuichetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/guichet")
 */
class GuichetController extends AbstractController
{
    /**
     * @Route("/", name="guichet_index", methods={"GET"})
     */
    public function index(GuichetRepository $guichetRepository): Response
    {        
        return $this->render('guichet/index.html.twig', [
            'guichets' => $guichetRepository->findBy(array(), array('createdAt' => 'DESC')),
        ]);
    }

    /**
     * @Route("/new", name="guichet_new", methods={"GET","POST"})
     */
    public function new(Request $request, GuichetRepository $guichetRepository): Response
    {
        $guichet = new Guichet();
        $form = $this->createForm(GuichetType::class, $guichet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $guichet1 = $guichetRepository->findOneBy([
                'nom' => $guichet->getNom(),
            ]);

            if (!$guichet1) {
                $guichet->setCreatedAt($this->test35());
                $guichet->setUpdatedAt($this->test35());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($guichet);
                $entityManager->flush();

                /// Message de confirmation
                //$this->addFlash('info','Guichet '.$guichet->getNom().' a été créer');

                return $this->render('guichet/index.html.twig', [
                    'guichets' => $guichetRepository->findAll(),
                    'success' => 'Guichet '.$guichet->getNom().' a été créer',
                ]);
            }else {
                return $this->render('guichet/new.html.twig', [
                    'guichet' => $guichet,
                    'form' => $form->createView(),
                    'error' => 'Guichet '.$guichet->getNom().' existe déjà',
                ]);
            }
            
        }

        return $this->render('guichet/new.html.twig', [
            'guichet' => $guichet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guichet_show", methods={"GET"})
     */
    public function show(Guichet $guichet): Response
    {
        return $this->render('guichet/show.html.twig', [
            'guichet' => $guichet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="guichet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Guichet $guichet): Response
    {
        //$form = $this->createForm(GuichetType::class, $guichet);
        $form = $this->createFormBuilder($guichet)
                ->add('code')
                ->add('nom')
            ->add('lieu', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'libelle'
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guichet->setUpdatedAt($this->test35());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guichet_index', [
                'id' => $guichet->getId(),
            ]);
        }

        return $this->render('guichet/edit.html.twig', [
            'guichet' => $guichet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guichet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Guichet $guichet): Response
    {
        $ptb = $this->getDoctrine()->getRepository(BilletPtb::class)->findOneBy([
            'guichet' => $guichet
        ]);
        $navette = $this->getDoctrine()->getRepository(BilletNavette::class)->findOneBy([
            'guichet' => $guichet
        ]);
        if($ptb)
        {
            return $this->render('guichet/show.html.twig', [
            'guichet' => $guichet,
            'error' => "Il y'a une contrainte d'integrité entre 'Guichet' et 'Billet PTB'"
        ]);
        }


        if($navette)
        {
            return $this->render('guichet/show.html.twig', [
            'guichet' => $guichet,
            'erreur' => "Il y'a une contrainte d'integrité entre 'Guichet' et 'Billet Navette'"
        ]);
        }
        if ($this->isCsrfTokenValid('delete'.$guichet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($guichet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('guichet_index');
    }
}
