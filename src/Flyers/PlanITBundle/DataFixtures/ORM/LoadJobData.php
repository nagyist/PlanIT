<?php

namespace Flyers\PlanITBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Flyers\PlanITBundle\Entity\Job;

class LoadJobData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

		private $container;
		
		public function setContainer(ContainerInterface $container = null)
		{
			$this->container = $container;
		}
		
    public function load(ObjectManager $manager)
    {
    
    	$jobTest = new Job();
    	$jobTest->setName("Webdesigner");
    	$jobTest->setDescription("Design web pages");
    	
    	$manager->persist($jobTest);
    	$manager->flush();
    	
    	$this->addReference('job-webdesigner', $jobTest);
    	
    	$jobTest = new Job();
    	$jobTest->setName("Webdeveloper");
    	$jobTest->setDescription("Develop web pages");
    	
    	$manager->persist($jobTest);
    	$manager->flush();
    	
    	$this->addReference('job-webdeveloper', $jobTest);
    	
    	$jobTest = new Job();
    	$jobTest->setName("Project manager");
    	$jobTest->setDescription("Manage projects");
    	
    	$manager->persist($jobTest);
    	$manager->flush();
    	
    	$this->addReference('job-pm', $jobTest);
    	
    	$jobTest = new Job();
    	$jobTest->setName("System Administrator");
    	
    	$manager->persist($jobTest);
    	$manager->flush();
    	
    	$this->addReference('job-sysadmin', $jobTest);
    	
    	$jobTest = new Job();
    	$jobTest->setName("Account manager");
    	
    	$manager->persist($jobTest);
    	$manager->flush();
    	
    	$this->addReference('job-accmanager', $jobTest);

    }
    
    public function getOrder()
    {
	    return 3;
    }
}