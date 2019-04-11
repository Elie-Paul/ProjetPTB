<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BilletPtb;
use App\Entity\BilletNavette;
use App\Entity\CommandePtb;
use App\Entity\StockPtb;
use App\Entity\StockVignette;
use App\Entity\StockTaxe;
use App\Entity\StockNavette;
use App\Entity\CommandeNavette;
use App\Entity\CommandeTaxe;
use App\Entity\CommandeVignette;
use App\Entity\BilletTaxe;
use App\Entity\Vignette;
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
        
         $arr=explode("+",$numDepartMotif);
         $num = intval($arr[0]);
         $motif = $arr[1];
         $depart = intval($arr[2]);
         $userid = intval($arr[3]);
         $color = $arr[4];
         $entityManager = $this->getDoctrine()->getManager();
         $billet = $entityManager->getRepository(BilletPtb::class)->find($id);
         $user = $entityManager->getRepository(User::class)->find($userid);
         if($depart ==$billet->getNumeroDernierBillets())
         {
            $testMotif="true";
         }
         else
         {
            $testMotif="false";
         }
         $stockPtb=$entityManager->getRepository(StockPtb::class)->findOneBy([
            'billet' => $billet,
         ],);
         $commnadesPTB = $entityManager->getRepository(CommandePtb::class)->findBy
         (
             [
                'billet' => $billet,
             ],
             ['dateCommande' =>'ASC']
         );
         $array=array();
         $j =0 ;
         for( $i=$depart;;$i++)
         {
            $pre = '';
            if ($i < 10) 
            {
                $pre="0000";
            } 
            else if ($i <100)
            {
                $pre="000";
            }
            else if ($i <100)
            {
                $pre="000";
            }
            else if ($i <1000)
            {
                $pre="00";
            }
            else if ($i <10000)
            {
                $pre="0";
            }
            $k=$pre.$i;
            array_push($array, $k);
             $j++;
             if( $j == $num)
                break;
         }
         if($testMotif == "true")
        {
            $stockPtb->setNbre( $stockPtb->getNbre() + $num );
        }
        else
        {
            $bb=$num - ($billet->getNumeroDernierBillets() - $depart);
            if($bb > 0)
            {
                $stockPtb->setNbre( $stockPtb->getNbre() + $bb) ;
            }
            
            $num=$bb;
        }
        $billet->setNumeroDernierBillets(end($array)+1);
        $a=0;
        $d=0;
        $test=array();
        
        
        while ($a<count($commnadesPTB)) 
        {
            for ($d;$d<$num;$d++) 
            {
                if($commnadesPTB[$a]->getEtatCommande() == 0 || $commnadesPTB[$a]->getEtatCommande() >= 3 )
                {
                    array_push($test, $commnadesPTB[$a]->getId());
                    break;
                }
                else
                {
                    if($commnadesPTB[$a]->getNombreBilletRealise() == $commnadesPTB[$a]->getNombreBillet())
                    {
                        $commnadesPTB[$a]->setEtatCommande(3);
                        break;
                    }
                    else
                    {
                        $commnadesPTB[$a]->setNombreBilletRealise(
                            $commnadesPTB[$a]->getNombreBilletRealise()+1
                        );
                        $commnadesPTB[$a]->setEtatCommande(2);
                    }
                    
                    
                    
                   
                    
                }
            }
            if($commnadesPTB[$a]->getNombreBilletRealise() == $commnadesPTB[$a]->getNombreBillet())
            {
                $commnadesPTB[$a]->setEtatCommande(3);
                    
            }
            $a++;
        }
        
        $entityManager->flush();
        $date=new \DateTime();
       // $mail->sendMailForPrint($depart, end($array));
         return $this->render('impression/index.html.twig', [
             'billet' => $billet,'nbrebillet' => $array,'color' => $color,'date' => $date,'motif'=>$motif,'nDepart'=>$depart,'nLast'=>end($array),'testMotif'=> $testMotif,
         ]);
         
        // return new Response(var_dump($test));
    }
    /**
    * @Route("/impressionAutorail/{id}/{numDepartMotif}",name="impressionAutorail_process")
    */
    public function show3($id,$numDepartMotif)
    {
        
         $arr=explode("+",$numDepartMotif);
         $num = intval($arr[0]);
         $motif = $arr[1];
         $depart = intval($arr[2]);
         $userid = intval($arr[3]);
         $color = $arr[4];
         $entityManager = $this->getDoctrine()->getManager();
         $billet = $entityManager->getRepository(BilletNavette::class)->find($id);
         $user = $entityManager->getRepository(User::class)->find($userid);
         if($depart ==$billet->getNumeroDernierBillet())
         {
            $testMotif="true";
         }
         else
         {
            $testMotif="false";
         }
         $stockNavette=$entityManager->getRepository(StockNavette::class)->findOneBy([
            'billet' => $billet,
         ],);
         $commnadesNavettes = $entityManager->getRepository(CommandeNavette::class)->findBy
         (
             [
                'billet' => $billet,
             ],
             ['dateCommande' =>'ASC']
         );
         $array=array();
         $j =0;
         for( $i=$depart;;$i++)
         {
            $pre = '';
            if ($i < 10) 
            {
                $pre="0000";
            } 
            else if ($i <100)
            {
                $pre="000";
            }
            else if ($i <100)
            {
                $pre="000";
            }
            else if ($i <1000)
            {
                $pre="00";
            }
            else if ($i <10000)
            {
                $pre="0";
            }
            $k=$pre.$i;
            array_push($array, $k);
             $j++;
             if( $j == $num)
                break;
         }
         if($testMotif == "true")
         {
            $stockNavette->setNbre( $stockNavette->getNbre() + $num );
         }
         else
         {
             
            $bb=$num - ($billet->getNumeroDernierBillets() - $depart);
            if($bb > 0)
            {
                $stockNavette->setNbre( $stockNavette->getNbre() + $bb) ;
            }    
             $num=$bb;
         }
        $billet->setNumeroDernierBillet(end($array)+1);
        $a=0;
        $d=0;
        $test=array();
        while ($a<count($commnadesNavettes)) 
        {
            for ($d;$d<$num;$d++) 
            {
                if($commnadesNavettes[$a]->getEtatCommande() == 0 || $commnadesNavettes[$a]->getEtatCommande() >= 3)
                {
                    array_push($test, $commnadesNavettes[$a]->getId());
                    break;
                }
                else
                {
                    if($commnadesNavettes[$a]->getNombreBilletRealise()== $commnadesNavettes[$a]->getNombreBillet())
                    {
                        $commnadesNavettes[$a]->setEtatCommande(3);
                        break;
                    }
                    else
                    {
                        $commnadesNavettes[$a]->setNombreBilletRealise(
                            $commnadesNavettes[$a]->getNombreBilletRealise()+1
                        );
                        $commnadesNavettes[$a]->setEtatCommande(2);
                    }
                    
                    
                    
                   
                    
                }
            }
            if($commnadesNavettes[$a]->getNombreBilletRealise()== $commnadesNavettes[$a]->getNombreBillet())
            {
                        $commnadesNavettes[$a]->setEtatCommande(3);
            }
            $a++;
        }
   
        $entityManager->flush();
        $date=new \DateTime();
         return $this->render('impression/index2.html.twig', [
             'billet' => $billet,'nbrebillet' => $array,'color' => $color,'date' =>$date,'motif'=>$motif,'nDepart'=>$depart,'nLast'=>end($array),'testMotif'=> $testMotif,
         ]);
    }
    /**
    * @Route("/impressiontaxes/{id}/{numDepartMotif}",name="impressiontaxes_process")
    */
    public function show4($id,$numDepartMotif)
    {
        
         $arr=explode("+",$numDepartMotif);
         $num = intval($arr[0]);
         $motif = $arr[1];
         $depart = intval($arr[2]);
         $userid = intval($arr[3]);
         $color = $arr[4];
         $entityManager = $this->getDoctrine()->getManager();
         $billet = $entityManager->getRepository(BilletTaxe::class)->find($id);
         $user = $entityManager->getRepository(User::class)->find($userid);
         $stockTaxe=$entityManager->getRepository(StockTaxe::class)->findOneBy([
            'billet' => $billet,
         ],);
         $user = $entityManager->getRepository(User::class)->find($userid);
         if($depart ==$billet->getNumeroDernierBillet())
         {
            $testMotif="true";
         }
         else
         {
            $testMotif="false";
         }
         $commnadesTaxes = $entityManager->getRepository(CommandeTaxe::class)->findBy
         (
            [
               'billet' => $billet,
            ],
            ['dateCommande' =>'ASC']
        );
        
         $array=array();
         $j =0;
         for( $i=$depart;;$i++)
         {
            $pre = '';
            if ($i < 10) 
            {
                $pre="0000";
            } 
            else if ($i <100)
            {
                $pre="000";
            }
            else if ($i <100)
            {
                $pre="000";
            }
            else if ($i <1000)
            {
                $pre="00";
            }
            else if ($i <10000)
            {
                $pre="0";
            }
            $k=$pre.$i;
            array_push($array, $k);
             $j++;
             if( $j == $num)
                break;
         }
         
         if($testMotif == "true")
         {
            $stockTaxe->setNbre( $stockTaxe->getNbre() + $num );
         }
         else
         {
            $bb=$num - ($billet->getNumeroDernierBillets() - $depart);
            if($bb > 0)
            {
                $stockTaxe->setNbre( $stockTaxe->getNbre() + $bb) ;
            }
            $num=$bb;
         }
        $billet->setNumeroDernierBillet(end($array));
        $a=0;
        $d=0;
        $test=array();
        while ($a<count($commnadesTaxes)) 
        {
            for ($d;$d<$num;$d++) 
            {
                if($commnadesTaxes[$a]->getEtatCommande() == 0 || $commnadesTaxes[$a]->getEtatCommande() >= 3)
                {
                    array_push($test, $commnadesTaxes[$a]->getId());
                    break;
                }
                else
                {
                    if($commnadesTaxes[$a]->getNombreBilletRealise()== $commnadesTaxes[$a]->getNombreBillet())
                    {
                        $commnadesTaxes[$a]->setEtatCommande(3);
                        break;
                    }
                    else
                    {
                        $commnadesTaxes[$a]->setNombreBilletRealise(
                            $commnadesTaxes[$a]->getNombreBilletRealise()+1
                        );
                        $commnadesTaxes[$a]->setEtatCommande(2);
                    }
                    
                    
                    
                   
                    
                }
            }
            if($commnadesTaxes[$a]->getNombreBilletRealise()== $commnadesTaxes[$a]->getNombreBillet())
                    {
                        $commnadesTaxes[$a]->setEtatCommande(3);
                    }
            $a++;
        }
        $entityManager->flush();
        $date=new \DateTime();
         return $this->render('impression/index3taxes.html.twig', [
             'billet' => $billet,'nbrebillet' => $array,'color' => $color,'date' =>$date,'motif'=>$motif,'nDepart'=>$depart,'nLast'=>end($array),'testMotif'=> $testMotif
         ]);
    }
    /**
    * @Route("/impressionvignette/{id}/{numDepartMotif}",name="impressionVignette_process")
    */
    public function show5($id,$numDepartMotif)
    {
        
         $arr=explode("+",$numDepartMotif);
         $num = intval($arr[0]);
         $motif = $arr[1];
         $depart = intval($arr[2])+1;
         $userid = intval($arr[3]);
         $color = $arr[4];
         $entityManager = $this->getDoctrine()->getManager();
         $billet = $entityManager->getRepository(Vignette::class)->find($id);
         $stockVignette=$entityManager->getRepository(StockVignette::class)->findOneBy([
            'billet' => $billet,
         ],);
         $user = $entityManager->getRepository(User::class)->find($userid);
         if($depart ==$billet->getNumeroDernierBillet())
         {
            $testMotif="true";
         }
         else
         {
            $testMotif="false";
         }
         $commnadesVignettes = $entityManager->getRepository(CommandeVignette::class)->findBy
         (
            [
               'billet' => $billet,
            ],
            ['dateCommande' =>'ASC']
        );
         $array=array();
         $j =0;
         for( $i=$depart;;$i++)
         {
            $pre = '';
            if ($i < 10) 
            {
                $pre="0000";
            } 
            else if ($i <100)
            {
                $pre="000";
            }
            else if ($i <100)
            {
                $pre="000";
            }
            else if ($i <1000)
            {
                $pre="00";
            }
            else if ($i <10000)
            {
                $pre="0";
            }
            $k=$pre.$i;
            array_push($array, $k);
             $j++;
             if( $j == $num)
                break;
         }
         if($testMotif == "true")
         {
            $stockVignette->setNbre( $stockVignette->getNbre() + $num );
         }
         else
         {
             $bb=$num - $billet->getNumeroDernierBillet() - $depart;
             if($bb > 0)
             {
                $stockVignette->setNbre( $stockVignette->getNbre() + $bb) ;
             }
             $num=$bb;
         }
        $billet->setNumeroDernierBillet(end($array)+1);
        $a=0;
        $d=0;
        $test=array();
        
        while ($a<count($commnadesVignettes)) 
        {
            for ($d;$d<$num;$d++) 
            {
                if($commnadesVignettes[$a]->getEtatCommande() == 0 || $commnadesVignettes[$a]->getEtatCommande() >= 3)
                {
                    array_push($test, $commnadesVignettes[$a]->getId());
                    break;
                }
                else
                {
                    if($commnadesVignettes[$a]->getNombreBilletRealise()== $commnadesVignettes[$a]->getNombreBillet())
                    {
                        $commnadesVignettes[$a]->setEtatCommande(3);
                        break;
                    }
                    else
                    {
                        $commnadesVignettes[$a]->setNombreBilletRealise(
                            $commnadesVignettes[$a]->getNombreBilletRealise()+1
                        );
                        $commnadesVignettes[$a]->setEtatCommande(2);
                    }
                    
                    
                    
                   
                    
                }
            }
            if($commnadesVignettes[$a]->getNombreBilletRealise()== $commnadesVignettes[$a]->getNombreBillet())
                    {
                        $commnadesVignettes[$a]->setEtatCommande(3);
                    }
            $a++;
        }
        $entityManager->flush();
        $date=new \DateTime();
         return $this->render('impression/indexvignette.html.twig', [
             'billet' => $billet,'nbrebillet' => $array,'color' => $color,'date' =>$date ,'motif'=>$motif,'nDepart'=>$depart,'nLast'=>end($array),'testMotif'=> $testMotif
         ]);
    }
}
