<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Trajet;
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
        $user->setUsername("thera");
        $user->setNom("THERA");
        $user->setPrenom("THERA");
        $user->setEmail("taalr@taalr.com");
        $user->setFilename("taalr");
        $user->setCreatedAt(new \DateTime());
        $user->setUpdateAt(new \DateTime());

        $roles [] = "Administrateur";
        //$user->setRoles($roles[0]);
        $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                         'passer'
                    ));
        $manager->persist($user);
        $manager->flush();
    }
}
