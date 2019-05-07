<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Trajet;
use App\Entity\TypeAudit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user=new User();
        $user->setUsername("Admin");
        $user->setNom("Admin");
        $user->setActive(true);
        $user->setPrenom("Admin");
        $user->setEmail("taalr@taalr.com");
        $user->setFilename("taalr");
        $user->setCreatedAt(new \DateTime());
        $user->setUpdateAt(new \DateTime());

        $roles [] = '""ROLE_ADMINISTRATEUR"';
        //$user->setRoles($roles[0]);
        $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                         'admin'
                    ));

        $typeAudit1=new TypeAudit();
        $typeAudit1->setLibelle("impression");                    

        $typeAudit2=new TypeAudit();                    
        $typeAudit2->setLibelle("impression irreguliére");

        $typeAudit3=new TypeAudit();                    
        $typeAudit3->setLibelle("retour billet normale");

        $typeAudit4=new TypeAudit();
        $typeAudit4->setLibelle("retour billet irregulier");                      
        $manager->persist($user);

        $manager->persist($typeAudit1);
        $manager->persist($typeAudit2);
        $manager->persist($typeAudit3);
        $manager->persist($typeAudit4);

        $manager->flush();
    }
}
