<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setFirstname('Cédric')
            ->setLastname('Cardoso')
            ->setEmail('x-estrela57@live.fr')
            ->setBirthAt(new \DateTime('now'))
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'azerty'))
            ->setIsValidate(true)
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);  
        $manager->flush();
    }
}
