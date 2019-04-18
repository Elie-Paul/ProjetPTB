<?php

namespace App\Controller;

use App\Entity\BilletNavette;
use App\Entity\StockNavette;
use App\Form\BilletNavetteType;
use App\Controller\ControllerCommandeNavetteController;
use App\Repository\BilletNavetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/billet/navette")
 */
class BilletNavetteController extends AbstractController
{
    /**
     * @Route("/", name="billet_navette_index", methods={"GET"})
     * @param billetNavetteRepository $billetNavetteRepository
     * @return Response
     */
    public function index(BilletNavetteRepository $billetNavetteRepository,Request $request,ControllerCommandeNavetteController $controller): Response
    {

        $array = array();
        foreach ($billetNavetteRepository->findAll() as $key => $value) 
        {
            $arr = array();
            $id = $value->getId();
            $total = intVal($controller->totalBillet2($id));
            $arr = ['billet' => $value,'total' => $total];
            array_push($array,$arr);
        }    
    return $this->render('billet_navette/index.html.twig', [
        'billet_navettes' =>$array,
    ]);
    }

    /**
     * @Route("/index2", name="billet_navette_index2", methods={"GET"})
     */
    public function index2(BilletNavetteRepository $billetNavetteRepository): Response
    {
        return $this->render('billet_navette/index2.html.twig', [
            'billet_navettes' => $billetNavetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="billet_navette_new", methods={"GET","POST"})
     */
    public function new(Request $request, BilletNavetteRepository $billetNavetteRepository): Response
    {
        $billetNavette = new BilletNavette();
        $stockNavette = new StockNavette();
        $form = $this->createForm(BilletNavetteType::class, $billetNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $billetNavette1 = $billetNavetteRepository->findOneBy([
                'guichet' => $billetNavette->getGuichet(),
                'navette' => $billetNavette->getNavette(),
            ]);

            $billetNavette2 = $billetNavetteRepository->findOneBy([
                'navette' => $billetNavette->getNavette(),
            ]);

            if(!$billetNavette1 && !$billetNavette2){
                $billetNavette->setCreatedAt($this->test35());
                $billetNavette->setUpdatedAt($this->test35());
                $billetNavette->setNumeroDernierBillet(0);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($billetNavette);
                $stockNavette->setBillet($billetNavette);
                $stockNavette->setNbre(0);
                $stockNavette->setCreatedAt($this->test35());
                $stockNavette->setUpdatedAt($this->test35());
                $entityManager->persist($stockNavette);
                $entityManager->flush();

                //return $this->redirectToRoute('billet_navette_index');
                return $this->render('billet_navette/index2.html.twig', [
                    'billet_navettes' => $billetNavetteRepository->findAll(),
                    'success' => 'Le train Autorail '.$billetNavette->getNavette().' a été créer',
                ]);
            }else{
                return $this->render('billet_navette/new.html.twig', [
                    'billet_navette' => $billetNavette,
                    'form' => $form->createView(),
                    'error' => 'Le train Autorail '.$billetNavette->getNavette().' existe déjà',
                ]);
            }
            
        }

        return $this->render('billet_navette/new.html.twig', [
            'billet_navette' => $billetNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_navette_show", methods={"GET"})
     */
    public function show(BilletNavette $billetNavette): Response
    {
        return $this->render('billet_navette/show.html.twig', [
            'billet_navette' => $billetNavette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="billet_navette_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BilletNavette $billetNavette): Response
    {
        $form = $this->createForm(BilletNavetteType::class, $billetNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('billet_navette_index', [
                'id' => $billetNavette->getId(),
            ]);
        }

        return $this->render('billet_navette/edit.html.twig', [
            'billet_navette' => $billetNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_navette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BilletNavette $billetNavette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$billetNavette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($billetNavette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('billet_navette_index');
    }
}
