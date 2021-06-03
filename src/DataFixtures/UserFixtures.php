<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use DateTime;
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

        $faker = Factory::create('fr_FR');
        $users = [];
        for($i = 0;$i < 25;$i++){
            $newUser = new User();
            $newUser
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setEmail($faker->email())
                ->setBirthAt(new \DateTime())
                ->setPassword($this->passwordEncoder->encodePassword(
                    $newUser,
                    'azerty'))
                ->setIsValidate(true)
                ->setRoles(['ROLE_USER']);

            $manager->persist($newUser);
            $users[] = $newUser;
        }
        $manager->flush();
        
        $tab_post = [];
        for($i = 0;$i < 100;$i++){
            $newPost = new Post();
            $newPost
                ->setContent($faker->realText())
                ->setPublishedAt(new \DateTime())
                ->setUser($faker->randomElement($users));
            $manager->persist($newPost);
            $tab_post[] = $newPost;
        }
        $manager->flush();

        //création de commentaires aléatoires
        for($i = 0;$i < 50;$i++){
            $newCom = new Comment();
            $newCom
                ->setContent($faker->realText())
                ->setAuthor($faker->randomElement($users))
                ->setCreatedAt(new \DateTime())
                ->setConcern($faker->randomElement($tab_post));
            $manager->persist($newCom);
        }
        $manager->flush();
    }
}
