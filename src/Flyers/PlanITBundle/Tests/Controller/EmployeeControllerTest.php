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
        if (property_exists($employee, 'phone'))
        $this->assertInternalType( "string", $employee->{'phone'} );
        
        if (property_exists($employee, 'salary'))
        {
	        if (is_double($employee->{'salary'}))
		        $this->assertInternalType( "float", $employee->{'salary'} );
	        else
		        $this->assertInternalType( "integer", $employee->{'salary'} );
        }
        $this->assertInternalType( "object", $employee->{'job'} );
        
        $this->assertFalse( property_exists($employee, 'tasks') );
				$this->assertFalse( property_exists($employee, 'charges') );
        
        $this->assertFalse( property_exists($employee, 'user') );
                
      }
      
      $client->insulate(); 
    }
    
    public function testGetEmployeesUser()
    {
	    $client = static::createClient();
	    
	    $client->request('GET', '/api/users');
	    $json = json_decode($client->getResponse()->getContent());
	    
	    if(!property_exists($json, 'users')) print_r($client->getResponse()->getContent());
	    $users_length = count($json->{'users'});
	    if ($users_length > 0)
	    {
		    $user = $json->{'users'}[$users_length-1];
		    $this->{'id_user'} = $user->{'id'};
	    }
	    
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
	    
	    $client->request('GET', '/api/users');
	    $json = json_decode($client->getResponse()->getContent());
	    if(!property_exists($json, 'users')) print_r($client->getResponse()->getContent());
	    $users_length = count($json->{'users'});
	    if ($users_length > 0)
	    {
		    $user = $json->{'users'}[$users_length-1];
		    $this->{'id_user'} = $user->{'id'};
	    }
	    
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
			
			// Test already existing employee
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
                  
      $client->insulate();
	    
    }    
    
    public function testPut()
    {
	    $client = static::createClient();
	    
	    $client->request('GET', '/api/users');
	    $json = json_decode($client->getResponse()->getContent());
	    if(!property_exists($json, 'users')) print_r($client->getResponse()->getContent());
	    $users_length = count($json->{'users'});
	    if ($users_length > 0)
	    {
		    $user = $json->{'users'}[$users_length-1];
		    $this->{'id_user'} = $user->{'id'};
	    }
	    
	    $crawler = $client->request('GET', '/api/employees');
      $json = json_decode($client->getResponse()->getContent());      
      $employees_length = count($json->{'employees'});
      if ($employees_length > 0)
      {      
	      $employee = $json->{'employees'}[$employees_length-1];	      
	      $this->{'id_employee'} = $employee->{'id'};
			}     
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
      $fields["lastname"] 		= "Doey";
      $fields["firstname"] 		= "Johnny";
      $fields["email"] 		= "johnny.doey@doe.com";
      
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
      /*
      if ( $json->{'error'} == "success" )
      {
	      $employee = $json->{'employee'};
	      
	      $client->request('DELETE', '/api/employee/'.$employee->{'id'});
      }
      */
      $client->insulate();
      
      
      // Test success with all datas
      $client->request('GET', '/api/jobs');
			$json = json_decode($client->getResponse()->getContent());
      $jobs_length = count($json->{'jobs'});
      if ($jobs_length > 0)
      {
	      $job = $json->{'jobs'}[$jobs_length-1];
	      $this->{'id_job'} = $job->{'id'};
      }
	    
	    $fields["lastname"] 		= "Doeyy";
      $fields["firstname"] 		= "Johnnyy";
      $fields["email"] 		= "johnnyy.doeyy@doe.com";
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
