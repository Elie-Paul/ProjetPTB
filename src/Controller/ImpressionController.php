<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BilletPtb;
use Symfony\Component\HttpFoundation\Response;

class ImpressionController extends AbstractController
{
    /**
     * @Route("/impression", name="impression")
     */
    public function index()
    {
        return $this->render('impression/index.html.twig', [
            'controller_name' => 'ImpressionController',
        ]);
    }

    /**
    * @Route("/blogs/{id}/{num}",name="blog_show")
    */
   public function show($id,$num)
   {
        $entityManager = $this->getDoctrine()->getManager();
        $billet = $entityManager->getRepository(BilletPtb::class)->find($id);
        $n = intval($num) ;
        $array=array();
        for( $i=0;$i < $n;$i++)
        {
            array_push($array, $billet->getNumeroDernierBillets()+$i);
        }
        $billet->setNumeroDernierBillets($array[$n-1]+1);
        $entityManager->flush();
        return $this->render('impression/index.html.twig', [
            'billet' => $billet,'nbrebillet' => $array
        ]);
   }
}
