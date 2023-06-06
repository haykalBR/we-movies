<?php

namespace App\Infrastructure\DataFixtures;

use App\User\Domain\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$username, $password, $email, $roles]) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['admin', 'admin', 'admin@symfony.com', [User::ROLE_USER]],
            ['tom_admin', 'kitten', 'tom_admin@symfony.com', [User::ROLE_USER]],
            ['john_user', 'kitten', 'john_user@symfony.com', [User::ROLE_USER]],
        ];
    }
}
