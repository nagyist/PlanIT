<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{
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
        
        $this->assertNull($project->{'user'});
                
      }        
    }
    
    public function testGetEmployeesUser()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/employees/1');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "array", $json->{'employees'}  );
      
      
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
	    
    }
    
    public function testGet()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/employee/1');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'employee'}  );
      
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

    }
}
