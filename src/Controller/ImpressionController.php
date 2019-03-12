<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BilletPtb;
use App\Entity\User;
use App\Entity\Tracabilite;
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
   /**
    * @Route("/impression/{id}/{numDepartMotif}",name="impression_process")
    */
    public function show2($id,$numDepartMotif)
    {
         /*$entityManager = $this->getDoctrine()->getManager();
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
         ]);*/
         $arr=explode("+",$numDepartMotif);
         $num = intval($arr[0]);
         $motif = $arr[1];
         $depart = intval($arr[2]);
         $userid = intval($arr[3]);
         $entityManager = $this->getDoctrine()->getManager();
         $billet = $entityManager->getRepository(BilletPtb::class)->find($id);
         $user = $entityManager->getRepository(User::class)->find($userid);
         $array=array();
         $j =0 ;
         for( $i=$depart;;$i++)
         {
             array_push($array, $i);
             $j++;
             if( $j == $num)
                break;
         }
        $billet->setNumeroDernierBillets(end($array));
        $tracabilite = new Tracabilite();
        $tracabilite->setUser($user);
        $tracabilite->setPtb($billet->getPtb());
        $tracabilite->setType("Ptb");
        $tracabilite->setMotif($motif);
        $tracabilite->setNumDepart($depart);
        $tracabilite->setNumFin(end($array));
        $tracabilite->setCreatedAt(new \DateTime());
        $tracabilite->setUpdatedAt(new \DateTime());
        $entityManager->persist($tracabilite);
        $entityManager->flush();
         return $this->render('impression/index.html.twig', [
             'billet' => $billet,'nbrebillet' => $array
         ]);
    }
}
