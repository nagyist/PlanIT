<?php

namespace Flyers\PlanITBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Flyers\PlanITBundle\Entity\Charge;

class LoadChargeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

		private $container;
		
		public function setContainer(ContainerInterface $container = null)
		{
			$this->container = $container;
		}
		
    public function load(ObjectManager $manager)
    {
      
      $created = $this->getReference('project-corp')->getBegin();
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-kickoff'));
      $testCharge->setEmployee($this->getReference('employee-ermione'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(6*60);
      $testCharge->setTask($this->getReference('task-corp-server'));
      $testCharge->setEmployee($this->getReference('employee-fred'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      $created->add(new \DateInterval("P1D"));
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-doc'));
      $testCharge->setEmployee($this->getReference('employee-ermione'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-kickoff'));
      $testCharge->setEmployee($this->getReference('employee-ermione'));
      
      $manager->persist($testCharge);
      $manager->flush();

      
      
      $created->add(new \DateInterval("P1D"));
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-kickoff'));
      $testCharge->setEmployee($this->getReference('employee-ermione'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-database'));
      $testCharge->setEmployee($this->getReference('employee-harry'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      
      $created->add(new \DateInterval("P1D"));
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-database'));
      $testCharge->setEmployee($this->getReference('employee-harry'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-crud'));
      $testCharge->setEmployee($this->getReference('employee-harry'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      $created->add(new \DateInterval("P1D"));
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-crud'));
      $testCharge->setEmployee($this->getReference('employee-harry'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-webservice'));
      $testCharge->setEmployee($this->getReference('employee-harry'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      $created->add(new \DateInterval("P3D"));
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-webservice'));
      $testCharge->setEmployee($this->getReference('employee-harry'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4*60);
      $testCharge->setTask($this->getReference('task-corp-webservice'));
      $testCharge->setEmployee($this->getReference('employee-harry'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      
      $created->add(new \DateInterval("P1D"));
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(48*60);
      $testCharge->setTask($this->getReference('task-corp-webservice'));
      $testCharge->setEmployee($this->getReference('employee-harry'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
      
      
      $created = $this->getReference('project-metrics')->getBegin();
      $testCharge = new Charge();
      $testCharge->setCreated($created);
      $testCharge->setDuration(4.5*60);
      $testCharge->setTask($this->getReference('task-metrics-kickoff'));
      $testCharge->setEmployee($this->getReference('employee-ermione'));
      
      $manager->persist($testCharge);
      $manager->flush();
      
			
    }
    
    public function getOrder()
    {
	    return 6;
    }
}