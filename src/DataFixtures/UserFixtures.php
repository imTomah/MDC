<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $user = new User();
            $user
                ->setEmail('admin@mdc.fr')
                ->setUsername('mdc_admin_001')
                ->setPassword('patinoire')
                ->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);

        $manager->flush();
    }
}
