<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{

		private $id_task = 11;
		private $id_user = 1;
		private $id_project = 1;

    public function testCGet()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/api/tasks');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success" );
      
      $this->assertInternalType( "array", $json->{'tasks'}  );
      
      foreach($json->{'tasks'} as $task) {
      
      	$this->assertInternalType( "integer", $task->{'id'} );
      	$this->assertInternalType( "string", $task->{'name'} );
      	$this->assertInternalType( "string", $task->{'description'} );
      	$this->assertInternalType( "string", $task->{'begin'} );
      	$this->assertInternalType( "integer", $task->{'estimate'} );
      	$this->assertInternalType( "object", $task->{'project'} );
      	$this->assertInternalType( "array", $task->{'charges'} );
      	
      	if (property_exists( $task, 'parent' ))
      	{
	      	$this->assertInternalType( "object", $task->{'parent'} );
      	}
      	
      	if (property_exists( $task, 'children' ))
      	{
	      	$this->assertInternalType( "array", $task->{'children'} );
      	}
      	        
        $this->assertFalse( date_create($task->{'begin'}) === FALSE );
        
      }        
      
      $client->insulate();
    }
    
    public function testGetTasksUser()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/tasks/'.$this->{'id_user'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "array", $json->{'tasks'}  );
      
      $client->insulate();
      
      
      // Test wen it don't
      $crawler = $client->request('GET', '/api/tasks/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'tasks' ) );
      
      $client->insulate();
	    
    }
    
    public function testGet()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/task/'.$this->{'id_task'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'task'}  );
      
			$client->insulate();
      
      // Then when it won't
      $crawler = $client->request('GET', '/api/task/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'task' ) );
      
			$client->insulate();

    }
    
    public function testCPost()
    {
	    $client = static::createClient();

			$fields = array();
			
			$crawler = $client->request('GET', '/api/employees');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
                        
			$employees = array();
      $employees_length = count($json->{'employees'});
      
      for ( $i = $employees_length-1; $i >= $employees_length-4; $i-- )
      {
      	if ($i > 0) 
      	{
		      $cur_employee = $json->{'employees'}[$i];
		      array_push($employees, $cur_employee->{'id'});
	      }
      }
			      
			$client->insulate();
			
			$crawler = $client->request('GET', '/api/tasks');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
                  
      $this->assertEquals( $json->{'error'}, "success" );
      
      $tasks_length = count($json->{'tasks'});
      
      $task = $json->{'tasks'}[$tasks_length-1];
            
      $client->insulate();
			
			// Test without data
			$crawler = $client->request('POST', 
												    '/api/task',
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $client->insulate();
			      
      // Test without description / parent
      $begin = new \DateTime();
      
      $fields["user"] = $this->{'id_user'};
      $fields["project"] = $this->{'id_project'};
      $fields["employees"] = $employees;
            
      $fields["name"] = "Test task";
			$fields["begin"] = $begin->format("d/m/Y");      
			$fields["estimate"] = "1.5 days";
      
      $crawler = $client->request('POST', 
												    '/api/task',
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
			if (is_null($json)) print_r($client->getResponse()->getContent());            
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      if ( $json->{'error'} == "success" )
      {
	      $task = $json->{'task'};
	      
	      $client->request('DELETE', '/api/task/'.$task->{'id'});
      }

      
      $client->insulate();
      
			// Test with all data
      $fields["parent"] = $task->{'id'};
      $fields["description"] = "Test task description";
      
      $crawler = $client->request('POST', 
												    '/api/task',
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $client->insulate();
            
    }
    
    public function testPut()
    {
    	$client = static::createClient();

			$fields = array();
			
			$crawler = $client->request('GET', '/api/employees');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
                        
			$employees = array();
      $employees_length = count($json->{'employees'});
      
      for ( $i = $employees_length-1; $i >= $employees_length-4; $i-- )
      {
      	if ($i > 0) 
      	{
		      $cur_employee = $json->{'employees'}[$i];
		      array_push($employees, $cur_employee->{'id'});
	      }
      }
			      
			$client->insulate();
			
			$crawler = $client->request('GET', '/api/tasks');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
                  
      $this->assertEquals( $json->{'error'}, "success" );
      
      $tasks_length = count($json->{'tasks'});
      
      $task = $json->{'tasks'}[$tasks_length-1];
      
      $this->{'id_task'} = $task->{'id'};
			      
			$client->insulate();
			
			// Test without description / parent
      $begin = new \DateTime();
      
      $fields["user"] = $this->{'id_user'};
      $fields["project"] = $this->{'id_project'};
      $fields["employees"] = $employees;
            
      $fields["name"] = "Test task";
			$fields["begin"] = $begin->format("d/m/Y");      
			$fields["estimate"] = 1.5 * 24 * 60; // 1.5 days			
      
      $crawler = $client->request('PUT', 
												    '/api/task/'.$this->{'id_task'},
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
			if (is_null($json)) print_r($client->getResponse()->getContent());            
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $client->insulate();
      
			// Test with all data
      $fields["parent"] = $task->{'id'};
      $fields["description"] = "Test task description";
      
      $crawler = $client->request('PUT', 
												    '/api/task/'.$this->{'id_task'},
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $client->insulate();
	    
    }
    
    public function testDelete()
    {
    	$client = static::createClient();

			$crawler = $client->request('GET', '/api/tasks');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      if( $json->{'error'} == "success" ) {
      
	      $tasks_length = count($json->{'tasks'});
	      
	      $task = $json->{'tasks'}[$tasks_length-1];
				
	      $this->{'id_task'} = $task->{'id'};
      
      }
      
			$client->insulate();
	    
	    //Test when it don't work
	    $crawler = $client->request('DELETE', '/api/task/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
            
      $client->insulate();
	    
	    
	    // Test when it works
	    $crawler = $client->request('DELETE', '/api/task/'.$this->{'id_task'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      					      
      $json = json_decode($client->getResponse()->getContent());
      
      if (is_null($json)) print_r($client->getResponse()->getContent());
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
            
      $client->insulate();
			
	    
    }
}
