<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {

        // USER WITH ADMIN ROLE
        $user = new User();
        $user->setFirstname('AdminFirstname');
        $user->setLastname('AdminLastname');
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_ADMIN']);

        $hash = $this->passwordHasher->hashPassword($user, 'asd123');
        $user->setPassword($hash);

        $manager->persist($user);
        $manager->flush();

        // USER WITHOUT ROLE
        $user = new User();
        $user->setFirstname('User');
        $user->setLastname('WithoutRole');
        $user->setEmail('user1@test.com');
        $user->setRoles([]);

        $hash = $this->passwordHasher->hashPassword($user, 'asd123');
        $user->setPassword($hash);

        $manager->persist($user);
        $manager->flush();

        // USER WITHOUT USER ROLE
        $user = new User();
        $user->setFirstname('User');
        $user->setLastname('WithRoleUser');
        $user->setEmail('user2@test.com');
        $user->setRoles(['ROLE_USER']);

        $hash = $this->passwordHasher->hashPassword($user, 'asd123');
        $user->setPassword($hash);

        $manager->persist($user);
        $manager->flush();
    }
}
