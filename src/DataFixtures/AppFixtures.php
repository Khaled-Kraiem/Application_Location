<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $locateur2 = new User();
        $locateur1 = new User();
        $admin->setUsername('Admin');
        $locateur1->setUsername('locateur_1');
        $locateur2->setUsername('locateur_2');
        $admin->setEmail('khaled.kraiem.91@gmail.com');
        $locateur1->setEmail('locateur1@gmail.com');
        $locateur2->setEmail('locateur2@gmail.com');
        $admin->setPassword($this->encoder->encodePassword($admin, '12345678'));
        $locateur1->setPassword($this->encoder->encodePassword($locateur1, '12345678'));
        $locateur2->setPassword($this->encoder->encodePassword($locateur2, '12345678'));
        $admin->setRoles(['ROLE_ADMIN']);
        $locateur1->setRoles(['ROLE_LOCATEUR']);
        $locateur2->setRoles(['ROLE_LOCATEUR']);
        $manager->persist($admin);
        $manager->persist($locateur1);
        $manager->persist($locateur2);
        $manager->flush();
    }
}
