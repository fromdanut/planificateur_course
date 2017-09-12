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
        // Create 2 users, minus and cortex.
        $names = array(
            'minus',
            'cortex',
        );

        foreach ($names as $name) {
            $user = new User();
            $user->setUsername($name);
            $user->setEmail($name.'@mail.net');
            $user->setPassword($name);
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getOrder()
    {
    // the order in which fixtures will be loaded
    // the lower the number, the sooner that this fixture is loaded
    return 1;
    }
}
