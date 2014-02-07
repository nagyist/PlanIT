<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{

		private $id_employee = 1;
		private $id_user 		= 1;
		private $id_job 		= 1;

    public function testCGet()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/api/employees');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $this->assertInternalType( "array", $json->{'employees'}  );
      
      foreach($json->{'employees'} as $employee) {
        
        $this->assertInternalType( "integer", $employee->{'id'} );
        $this->assertInternalType( "string", $employee->{'lastname'} );
        $this->assertInternalType( "string", $employee->{'firstname'} );
        $this->assertInternalType( "string", $employee->{'email'} );
        $this->assertInternalType( "string", $employee->{'phone'} );
        $this->assertInternalType( "float", $employee->{'salary'} );
        $this->assertInternalType( "object", $employee->{'job'} );
        $this->assertInternalType( "array", $employee->{'tasks'} );
				$this->assertInternalType( "array", $employee->{'charges'} );
        
        $this->assertFalse( property_exists($employee, 'user') );
                
      }
      
      $client->insulate(); 
    }
    
    public function testGetEmployeesUser()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/employees/'.$this->{'id_user'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "array", $json->{'employees'}  );
      
      $client->insulate();
      
      
      // Test wen it don't
      $crawler = $client->request('GET', '/api/employees/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'employees' ) );
      
      $client->insulate();
	    
    }
    
    public function testGet()
    {
	    $client = static::createClient();
	    
	    $crawler = $client->request('GET', '/api/employees');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $employees_length = count($json->{'employees'});
      
      $employee = $json->{'employees'}[$employees_length-1];
			
      $this->{'id_employee'} = $employee->{'id'};
      
			$client->insulate();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/employee/'.$this->{'id_employee'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'employee'}  );
      
      $client->insulate();
      
      // Then when it won't
      $crawler = $client->request('GET', '/api/employee/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'employee' ) );
      
      $client->insulate();

    }
    
    public function testCpost()
    {
	    $client = static::createClient();
	    
	    $fields = array();
	    
	    $crawler = $client->request('POST', 
												    '/api/employee',
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
      
      // Test with already used email / lastname / firstname
      $crawler = $client->request('GET', '/api/employees');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $employees_length = count($json->{'employees'});
      
      $employee = $json->{'employees'}[$employees_length-1];
			      
			$client->insulate();
			
			// Test without datas
			$fields["user"] 		= $this->{'id_user'};
			$fields["lastname"] = $employee->{'lastname'};
			$fields["firstname"] = $employee->{'firstname'};
			$fields["email"] 		= $employee->{'email'};
			
			$crawler = $client->request('POST', 
												    '/api/employee',
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode( $client->getResponse()->getContent() );
            
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $client->insulate();
			      
      // Test without job / salary / phone
      
      $fields["lastname"] 		= "Doe";
      $fields["firstname"] 		= "John";
      $fields["email"] 		= "john.doe@doe.com";
      
	    $crawler = $client->request('POST', 
												    '/api/employee',
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
      
      if ( $json->{'error'} == "success" )
      {
	      $employee = $json->{'employee'};
	      
	      $client->request('DELETE', '/api/employee/'.$employee->{'id'});
      }
      
      $client->insulate();
      
      
      // Test success with all datas
      $client->request('GET', '/api/jobs');
      
			$json = json_decode($client->getResponse()->getContent());
			
			if( $json->{'error'} == "success" ) {
      
	      $jobs_length = count($json->{'jobs'});
	      
	      $job = $json->{'jobs'}[$jobs_length-1];
				
	      $this->{'id_job'} = $job->{'id'};

      }
	    
	    $fields["job"] 		 = $this->{'id_job'};
	    $fields["phone"] 	 = "555-1234";
	    $fields["salary"]  = 300.15;
	    
	    $crawler = $client->request('POST', 
												    '/api/employee',
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
      
      $employee = $json->{'employee'};
      
      $this->assertInternalType( "integer", $employee->{'id'} );
      $this->assertInternalType( "string", $employee->{'lastname'} );
      $this->assertInternalType( "string", $employee->{'firstname'} );
      $this->assertInternalType( "string", $employee->{'email'} );
      $this->assertInternalType( "string", $employee->{'phone'} );
      $this->assertInternalType( "float", $employee->{'salary'} );
      $this->assertInternalType( "object", $employee->{'job'} );
      $this->assertInternalType( "array", $employee->{'tasks'} );
			$this->assertInternalType( "array", $employee->{'charges'} );
      
      $this->assertFalse( property_exists($employee, 'user') );
      
      $this->{'id_employee'} = $employee->{'id'};
            
      $client->insulate();
	    
    }    
    
    public function testPut()
    {
	    $client = static::createClient();
	    
	    $crawler = $client->request('GET', '/api/employees');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
                  
      $this->assertEquals( $json->{'error'}, "success" );
      
      $employees_length = count($json->{'employees'});
      
      $employee = $json->{'employees'}[$employees_length-1];
      
      $this->{'id_employee'} = $employee->{'id'};
			      
			$client->insulate();
	    
	    // Test without datas
	    $fields = array();
	    
	    $crawler = $client->request('PUT', 
												    '/api/employee/'.$this->{'id_employee'},
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
      
      // Test with already used email / lastname / firstname
			$fields["user"] 		= $this->{'id_user'};
			$fields["lastname"] = $employee->{'lastname'};
			$fields["firstname"] = $employee->{'firstname'};
			$fields["email"] 		= $employee->{'email'};
			
			$crawler = $client->request('PUT', 
												    '/api/employee/'.$this->{'id_employee'},
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode( $client->getResponse()->getContent() );
            
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $client->insulate();
			      
      // Test without job / salary / phone
      $fields["lastname"] 		= "Doe";
      $fields["firstname"] 		= "John";
      $fields["email"] 		= "john.doe@doe.com";
      
	    $crawler = $client->request('PUT', 
												    '/api/employee/'.$this->{'id_employee'},
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
      
      if ( $json->{'error'} == "success" )
      {
	      $employee = $json->{'employee'};
	      
	      $client->request('DELETE', '/api/employee/'.$employee->{'id'});
      }
      
      $client->insulate();
      
      
      // Test success with all datas
      $client->request('GET', '/api/jobs');
      
			$json = json_decode($client->getResponse()->getContent());
			
			if( $json->{'error'} == "success" ) {
      
	      $jobs_length = count($json->{'jobs'});
	      
	      $job = $json->{'jobs'}[$jobs_length-1];
				
	      $this->{'id_job'} = $job->{'id'};

      }
	    
	    $fields["job"] 		 = $this->{'id_job'};
	    $fields["phone"] 	 = "555-1234";
	    $fields["salary"]  = 300.15;	    
	    
	    $crawler = $client->request('PUT', 
												    '/api/employee/'.$this->{'id_employee'},
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
      
      $employee = $json->{'employee'};
      
      $this->assertInternalType( "integer", $employee->{'id'} );
      $this->assertInternalType( "string", $employee->{'lastname'} );
      $this->assertInternalType( "string", $employee->{'firstname'} );
      $this->assertInternalType( "string", $employee->{'email'} );
      $this->assertInternalType( "string", $employee->{'phone'} );
      $this->assertInternalType( "float", $employee->{'salary'} );
      $this->assertInternalType( "object", $employee->{'job'} );
      $this->assertInternalType( "array", $employee->{'tasks'} );
			$this->assertInternalType( "array", $employee->{'charges'} );
      
      $this->assertFalse( property_exists($employee, 'user') );
      
      $this->{'id_employee'} = $employee->{'id'};
            
      $client->insulate();
	    
    } 
    
    public function testDelete()
    {
	    $client = static::createClient();
	    
	    $crawler = $client->request('GET', '/api/employees');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      if( $json->{'error'} == "success" ) {
      
	      $employees_length = count($json->{'employees'});
	      
	      $employee = $json->{'employees'}[$employees_length-1];
				
	      $this->{'id_employee'} = $employee->{'id'};
      
      }
      
			$client->insulate();
	    
	    //Test when it don't work
	    $crawler = $client->request('DELETE', '/api/employee/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
            
      $client->insulate();
	    
	    
	    // Test when it works
	    $crawler = $client->request('DELETE', '/api/employee/'.$this->{'id_employee'});
	    
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
