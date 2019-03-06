<?php

namespace App\DataFixtures;
use App\Entity\Lieux;
use App\Entity\Trajet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $lieux1 = $this->getDoctrine()->getRepository(Lieux::class)->find(1);
        $lieux2 = $this->getDoctrine()->getRepository(Lieux::class)->find(2);
        $lieux3 = $this->getDoctrine()->getRepository(Lieux::class)->find(3);        
        $lieux4 = $this->getDoctrine()->getRepository(Lieux::class)->find(4);  
        $trajet = new Trajet();
        $trajet->setDepart(1);
        $trajet->setArrivee(2);
        $trajet1 = new Trajet();
        $trajet1->setDepart(2);
        $trajet1->setArrivee(1);
        $trajet2 = new Trajet();
        $trajet2->setDepart(2);
        $trajet2->setArrivee(3);
        $manager->persist($lieu1);
        $manager->persist($lieu2);
        $manager->persist($lieu3);
        $manager->persist($lieu4);
        $manager->flush();
    }
}
