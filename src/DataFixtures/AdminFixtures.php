<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {}

    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
        $admin->setEmail('admin1@fccn.com');
        $admin->setPassword($this->hasher->hashPassword($admin, 'Azerty77'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setFirstname('Admin1');
        $admin->setLastname('ADMIN1');

        $manager->persist($admin);
        $manager->flush();
        
    }
}