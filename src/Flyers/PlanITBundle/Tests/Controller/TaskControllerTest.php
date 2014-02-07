<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
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
    }
    
    public function testGetTasksUser()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/tasks/1');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "array", $json->{'tasks'}  );
      
      
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
	    
    }
    
    public function testGet()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/task/11');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'task'}  );
      
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

    }
}
