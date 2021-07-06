<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setEmail("admin@admin.com");
        $user1->setFirstname("admin@admin.com");
        $user1->setRoles((array)"ROLE_ADMIN");

        $password = $this->encoder->encodePassword($user1,"admin");

        $user1->setPassword($password);
        $manager->persist($user1);
        $manager->flush();
    }
}
