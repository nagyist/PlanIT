<?php

namespace Flyers\PlanITBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Flyers\PlanITBundle\Entity\Role;

class LoadRoleData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userRole = new Role();
        $userRole->setName('ROLE_USER');

        $manager->persist($userRole);
        $manager->flush();
    }
}

?>