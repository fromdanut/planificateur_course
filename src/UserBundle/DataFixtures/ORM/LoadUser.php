<?php

// src/UserBundle/DataFixtures/ORM/LoadUser.php

namespace PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;


class LoadUser implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setUsername('minus');
        $user->setEmail('minus@mail.com');

        // Simule FOSUserBundle encryption to get a functioning user.
        $password = 'minus';
        $salt = '1234';
        $salted = $password.'{'.$salt.'}';
        $digest = hash('sha512', $salted, true);
        for ($i=1; $i<5000; $i++) {
            $digest = hash('sha512', $digest.$salted, true);
        }
        $encodedPassword = base64_encode($digest);

        $user->setSalt($salt);
        $user->setPassword($encodedPassword);
        $user->setEnabled(true);
        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
    // the order in which fixtures will be loaded
    // the lower the number, the sooner that this fixture is loaded
    return 1;
    }
}
