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
        $user = new User();
        $user->setEmail("user@admin.com");
        $user->setFirstname("user");
        $user->setName("userName");
        $user->setIsEnable(1);
        $user->setIsVisible(1);
        $user->setRoles((array)"ROLE_USER");
        $user->setPhoneNumber("0637610414");

        $password = $this->encoder->encodePassword($user,"user123");

        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();
    }
}
