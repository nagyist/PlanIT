<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChargeControllerTest extends WebTestCase
{

		private $id_charge 		= 1;
		private $id_task 			= 1;
		private $id_employee 	= 1;
		private $id_project 	= 1;

    public function testCGet()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/api/charges');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $this->assertInternalType( "array", $json->{'charges'}  );
      
      foreach($json->{'charges'} as $charge) {
      
      	$this->assertInternalType( "integer", $charge->{'id'} );
      	
      	if (property_exists($charge, 'description'))
      	$this->assertInternalType( "string", $charge->{'description'} );
      	
      	if (is_double($charge->{'duration'}))
      	$this->assertInternalType( "float", $charge->{'duration'} );
      	else
      	$this->assertInternalType( "integer", $charge->{'duration'} );      	
      	$this->assertInternalType( "string", $charge->{'created'} );
      	$this->assertInternalType( "object", $charge->{'employee'} );
      	$this->assertInternalType( "object", $charge->{'task'} );      	
      	
        $this->assertFalse( date_create($charge->{'created'}) === FALSE );
        
      }      
      
      $client->insulate();  
    }
    
    public function testGetChargesTask()
    {
	    $client = static::createClient();
	    
			$crawler = $client->request('GET', '/api/charges');
      
      $json = json_decode($client->getResponse()->getContent());
      
      if (!is_null($json))
      {
      	$charges = $json->{'charges'};
	      $charges_length = count($charges);
	      if ($charges_length > 0)
	      {
	      	$charge = $charges[$charges_length-1];
	      	$this->{'id_task'} = $charge->{'task'}->{'id'};
	      }
      }
      
      $client->insulate();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/charges/'.$this->{'id_task'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "array", $json->{'charges'}  );
      
      $client->insulate();
      
      
      // Test wen it don't
      $crawler = $client->request('GET', '/api/charges/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'charges' ) );
      
      $client->insulate();
	    
    }
    
    public function testGet()
    {
	    $client = static::createClient();
	    
	    $crawler = $client->request('GET', '/api/charges');
      
      $json = json_decode($client->getResponse()->getContent());
      
      if (!is_null($json))
      {
      	$charges = $json->{'charges'};
	      $charges_length = count($charges);
	      if ($charges_length > 0)
	      {
		      $charge = $charges[$charges_length-1];
		      $this->{'id_charge'} = $charge->{'id'};
	      }
      }
      
      $client->insulate();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/charge/'.$this->{'id_charge'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'charge'}  );
      
      $client->insulate();
      
      // Then when it won't
      $crawler = $client->request('GET', '/api/charge/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'charge' ) );
      
      $client->insulate();

    }
    
    public function testCPost()
    {
    	$client = static::createClient();
    	
    	$fields = array();
    	
    	
    	$crawler = $client->request('GET', '/api/tasks');
      
      $json = json_decode($client->getResponse()->getContent());
                  
      $this->assertEquals( $json->{'error'}, "success" );
      
      $tasks_length = count($json->{'tasks'});
      
      $task = $json->{'tasks'}[$tasks_length-1];
      
      $this->{'id_task'} = $task->id;
            
      $client->insulate();
      
      
      
      $crawler = $client->request('GET', '/api/employees');
      
      $json = json_decode($client->getResponse()->getContent());
                  
      $this->assertEquals( $json->{'error'}, "success" );
      
      $employees_length = count($json->{'employees'});
      
      $employee = $json->{'employees'}[$employees_length-1];
      
      $this->{'id_employee'} = $employee->{'id'};
            
      $client->insulate();
      
      
      
      $crawler = $client->request('GET', '/api/projects');
      
      $json = json_decode($client->getResponse()->getContent());
                  
      $this->assertEquals( $json->{'error'}, "success" );
      
      $projects_length = count($json->{'projects'});
      
      $project = $json->{'projects'}[$projects_length-1];
      
      $this->{'id_project'} = $project->{'id'};
            
      $client->insulate();
      
      // Test without data
			$crawler = $client->request('POST', 
												    '/api/charge',
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
      
      // Test without duration
      $created = new \DateTime();
      
      $fields["task"] = $this->{'id_task'};
      $fields["employee"] = $this->{'id_employee'};
      $fields["created"] = $created->format("d/m/Y");
      
      $crawler = $client->request('POST', 
												    '/api/charge',
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
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $client->insulate();
      
      // Test without project / description
      $fields["duration"] = "1.5 days";
      
      $crawler = $client->request('POST', 
												    '/api/charge',
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
      $fields["project"] = $this->{'id_project'};
      $fields["description"] = "Test charge description";
      
      $crawler = $client->request('POST', 
												    '/api/charge',
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
    		    
			
			$crawler = $client->request('GET', '/api/charges');
      
      $json = json_decode($client->getResponse()->getContent());
                  
      $this->assertEquals( $json->{'error'}, "success" );
      
      $charges_length = count($json->{'charges'});
      
      $charge = $json->{'charges'}[$charges_length-1];
      
      $this->{'id_charge'} = $charge->id;
            
      $client->insulate();
      
      
      //Test when it don't work
	    $crawler = $client->request('DELETE', '/api/charge/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
            
      $client->insulate();
	    
	    
	    // Test when it works
	    $crawler = $client->request('DELETE', '/api/charge/'.$this->{'id_charge'});
	    
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
