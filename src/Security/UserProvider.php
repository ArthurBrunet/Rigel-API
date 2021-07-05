<?php


namespace App\Security;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername($email)
    {
        $user = $this->findOneUserBy(['email' => $email]);

        if (!$user) {
            throw new UsernameNotFoundException(
                sprintf(
                    'L\'utilisateur au mail %s n\'existe pas.',
                    $email
                )
            );
        }
        return $user;
    }

    private function findOneUserBy(array $options): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy($options);
    }

    public function refreshUser(UserInterface $user)
    {
        assert($user instanceof User);

        if (null === $reloadedUser = $this->findOneUserBy(['id' => $user->getId()])) {
            throw new UsernameNotFoundException(
                sprintf(
                    'L\'utilisateur avec l\'id %s ne peut pas être rechargé.',
                    $user->getId()
                )
            );
        }
        return $reloadedUser;
    }

    public function supportsClass($class): bool
    {
        return $class === User::class;
    }
}