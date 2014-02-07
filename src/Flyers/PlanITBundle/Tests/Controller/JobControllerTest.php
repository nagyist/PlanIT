<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{
    public function testCGet()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/api/jobs');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $this->assertInternalType( "array", $json->{'jobs'}  );
      
      foreach($json->{'jobs'} as $job) {
      
      	$this->assertInternalType( "integer", $job->{'id'} );
      	$this->assertInternalType( "string", $job->{'name'} );
      	$this->assertInternalType( "string", $job->{'description'} );
      	$this->assertInternalType( "array", $job->{'employees'} );      	
      	        
      }        
    }
        
    public function testGet()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/job/1');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'job'}  );
      
      // Then when it won't
      $crawler = $client->request('GET', '/api/job/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'job' ) );

    }
}
