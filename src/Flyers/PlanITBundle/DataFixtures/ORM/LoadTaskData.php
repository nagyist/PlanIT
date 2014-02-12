<?php

namespace Flyers\PlanITBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Flyers\PlanITBundle\Entity\Task;

class LoadTaskData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

		private $container;
		
		public function setContainer(ContainerInterface $container = null)
		{
			$this->container = $container;
		}
		
    public function load(ObjectManager $manager)
    {
    
    	$begin = $this->getReference('project-corp')->getBegin();
      
      $testTask = new Task();
      $testTask->setName("Kickoff");
      $testTask->setDescription("Get user necessities");
      $testTask->setBegin($begin);
      $testTask->setEstimate(4*60);
      $testTask->setProject($this->getReference('project-corp'));
      $testTask->addEmployee($this->getReference('employee-ermione'));
      
      $manager->persist($testTask);
      $manager->flush();
      
      $this->addReference('task-corp-kickoff', $testTask);
      
      $testTask = new Task();
      $testTask->setName("Server configuration");
      $testTask->setBegin($begin);
      $testTask->setEstimate(24*60);
      $testTask->setProject($this->getReference('project-corp'));
      $testTask->addEmployee($this->getReference('employee-fred'));
      $testTask->addEmployee($this->getReference('employee-john'));       
      
      $manager->persist($testTask);
      $manager->flush();
      
      $this->addReference('task-corp-server', $testTask);
      
      $begin->add(new \DateInterval("PT4H"));
      $testTask = new Task();
      $testTask->setName("Requirement documentation");
      $testTask->setBegin($begin);
      $testTask->setEstimate(16*60);
      $testTask->setProject($this->getReference('project-corp'));
      $testTask->setParent($this->getReference('task-corp-kickoff'));
      $testTask->addEmployee($this->getReference('employee-ermione'));      
      
      $manager->persist($testTask);
      $manager->flush();
      
      $this->addReference('task-corp-doc', $testTask);
      
      $begin->add(new \DateInterval("PT16H"));
      $testTask = new Task();
      $testTask->setName("Database architecture");
      $testTask->setBegin($begin);
      $testTask->setEstimate(16*60);
      $testTask->setProject($this->getReference('project-corp'));
      $testTask->setParent($this->getReference('task-corp-doc'));
      $testTask->addEmployee($this->getReference('employee-harry'));      
      
      $manager->persist($testTask);
      $manager->flush();
      
      $this->addReference('task-corp-database', $testTask);
      
      
      $begin->add(new \DateInterval("PT16H"));
      $testTask = new Task();
      $testTask->setName("Create CRUD architecture");
      $testTask->setBegin($begin);
      $testTask->setEstimate(24*60);
      $testTask->setProject($this->getReference('project-corp'));
      $testTask->setParent($this->getReference('task-corp-database'));
      $testTask->addEmployee($this->getReference('employee-harry'));      
      
      $manager->persist($testTask);
      $manager->flush();
      
      $this->addReference('task-corp-crud', $testTask);
      
      
      $begin->add(new \DateInterval("PT24H"));
      $testTask = new Task();
      $testTask->setName("Webservices");
      $testTask->setBegin($begin);
      $testTask->setEstimate(48*60);
      $testTask->setProject($this->getReference('project-corp'));
      $testTask->setParent($this->getReference('task-corp-crud'));
      $testTask->addEmployee($this->getReference('employee-harry'));      
      
      $manager->persist($testTask);
      $manager->flush();
      
      $this->addReference('task-corp-webservice', $testTask);
      
      $begin = $this->getReference('project-metrics')->getBegin();
      $testTask = new Task();
      $testTask->setName("Kickoff");
      $testTask->setDescription("Get user necessities");
      $testTask->setBegin($begin);
      $testTask->setEstimate(4*60);
      $testTask->setProject($this->getReference('project-metrics'));
      $testTask->addEmployee($this->getReference('employee-ermione'));      
      
      $manager->persist($testTask);
      $manager->flush();
      
      $this->addReference('task-metrics-kickoff', $testTask);
      
			
    }
    
    public function getOrder()
    {
	    return 5;
    }
}