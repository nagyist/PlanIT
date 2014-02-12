<?php

namespace Flyers\PlanITBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Flyers\PlanITBundle\Entity\Employee;

class LoadEmployeeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

		private $container;
		
		public function setContainer(ContainerInterface $container = null)
		{
			$this->container = $container;
		}
		
    public function load(ObjectManager $manager)
    {
    
    	$employeeTest = new Employee();
    	$employeeTest->setFirstname("Joe");
    	$employeeTest->setLastname("Hooker");
    	$employeeTest->setEmail("joe@hooker.tv");
    	$employeeTest->setPhone("555-1234");
    	$employeeTest->setSalary(27.5);
    	$employeeTest->setUser($this->getReference('user-test'));
    	$employeeTest->setJob($this->getReference('job-webdesigner'));
    	
    	$manager->persist($employeeTest);
    	$manager->flush();
    	
    	$this->addReference('employee-joe', $employeeTest);
    	
    	$employeeTest = new Employee();
    	$employeeTest->setFirstname("Harry");
    	$employeeTest->setLastname("Potter");
    	$employeeTest->setEmail("ermione@hooker.tv");
    	$employeeTest->setSalary(30);
    	$employeeTest->setUser($this->getReference('user-test'));
    	$employeeTest->setJob($this->getReference('job-webdeveloper'));
    	
    	$manager->persist($employeeTest);
    	$manager->flush();
    	
    	$this->addReference('employee-harry', $employeeTest);
    	
    	$employeeTest = new Employee();
    	$employeeTest->setFirstname("Ermione");
    	$employeeTest->setLastname("Lee");
    	$employeeTest->setEmail("lee@hooker.tv");
    	$employeeTest->setSalary(35);
    	$employeeTest->setUser($this->getReference('user-test'));
    	$employeeTest->setJob($this->getReference('job-pm'));
    	
    	$manager->persist($employeeTest);
    	$manager->flush();
    	
    	$this->addReference('employee-ermione', $employeeTest);
    	
    	$employeeTest = new Employee();
    	$employeeTest->setFirstname("John");
    	$employeeTest->setLastname("Fidge");
    	$employeeTest->setEmail("john@hooker.tv");
    	$employeeTest->setUser($this->getReference('user-test'));
    	$employeeTest->setJob($this->getReference('job-webdeveloper'));
    	
    	$manager->persist($employeeTest);
    	$manager->flush();
    	
    	$this->addReference('employee-john', $employeeTest);
    	
    	
    	$employeeTest = new Employee();
    	$employeeTest->setFirstname("Fred");
    	$employeeTest->setLastname("Fidge");
    	$employeeTest->setEmail("john@hooker.tv");
    	$employeeTest->setUser($this->getReference('user-test'));
    	$employeeTest->setJob($this->getReference('job-sysadmin'));
    	
    	$manager->persist($employeeTest);
    	$manager->flush();
    	
    	$this->addReference('employee-fred', $employeeTest);
      
    }
    
    public function getOrder()
    {
	    return 4;
    }
}