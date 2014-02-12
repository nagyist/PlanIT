<?php

namespace Flyers\PlanITBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


use Flyers\PlanITBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

		private $container;
		
		public function setContainer(ContainerInterface $container = null)
		{
			$this->container = $container;
		}
		
    public function load(ObjectManager $manager)
    {
    
    	$um = $this->container->get('fos_user.user_manager');
    
			$userTest = new User();
			$email = 'test@test.com';
			$userTest->setUsername($email);
			$userTest->setEmail($email);
			$userTest->setPlainPassword('test');
			$userTest->setEnabled(true);
			
			$um->updateUser($userTest);
			
			$this->addReference('user-test', $userTest);			
			
			$userTest = new User();
			$email = 'bob@marley.com';
			$userTest->setUsername($email);
			$userTest->setEmail($email);
			$userTest->setPlainPassword('bob');
			$userTest->setEnabled(true);
			
			$um->updateUser($userTest);
			
			$this->addReference('user-bob', $userTest);
			
    }
    
    public function getOrder()
    {
	    return 1;
    }
}