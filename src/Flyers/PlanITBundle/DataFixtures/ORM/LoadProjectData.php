<?php

namespace Flyers\PlanITBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Flyers\PlanITBundle\Entity\Project;

class LoadProjectData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

		private $container;
		
		public function setContainer(ContainerInterface $container = null)
		{
			$this->container = $container;
		}
		
    public function load(ObjectManager $manager)
    {
      
      $begin 	= new \DateTime();
      $end 		= new \DateTime();
      $end->add(new \DateInterval("P1M"));
			$projectTest = new Project();
			$projectTest->setName("Corp Inc corporate website");
			$projectTest->setDescription("Corporative website of the Corp Inc company selling financial products");
			$projectTest->setBegin($begin);
			$projectTest->setEnd($end);
			$projectTest->addUser($this->getReference('user-test'));
			
			$manager->persist($projectTest);
			$manager->flush();
			
			$this->addReference('project-corp', $projectTest);
			
			
			$begin 	= new \DateTime();
      $end 		= new \DateTime();
      $end->add(new \DateInterval("P3M"));
			$projectTest = new Project();
			$projectTest->setName("Analytics Dashboard");
			$projectTest->setDescription("Visualisation Dashboard of social media metrics");
			$projectTest->setBegin($begin);
			$projectTest->setEnd($end);
			$projectTest->addUser($this->getReference('user-test'));
			
			$manager->persist($projectTest);
			$manager->flush();
			
			$this->addReference('project-metrics', $projectTest);
			
			$begin 	= new \DateTime();
      $end 		= new \DateTime();
      $end->add(new \DateInterval("P3M"));
			$projectTest = new Project();
			$projectTest->setName("E-commerce website");
			$projectTest->setBegin($begin);
			$projectTest->setEnd($end);
			$projectTest->addUser($this->getReference('user-test'));
			
			$manager->persist($projectTest);
			$manager->flush();
			
			$this->addReference('project-ecommerce', $projectTest);
			
    }
    
    public function getOrder()
    {
	    return 2;
    }
}