<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
            $user1 = new User();
            $user1
                ->setEmail('admin@mdc.fr')
                ->setUsername('mdc_admin_001')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user1,
                    'patinoire'
                ));
            $manager->persist($user1);

            $user2 = new User();
            $user2
                ->setEmail('tomah@orange.fr')
                ->setUsername('tomah')
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user2,
                    'patinoire'
                ));
            $manager->persist($user2);

        $manager->flush();
    }
}
