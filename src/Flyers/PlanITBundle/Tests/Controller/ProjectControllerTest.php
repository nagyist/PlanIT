<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    public function testCGet()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/api/projects');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success" );
      
      $this->assertInternalType( "array", $json->{'projects'}  );
      
      foreach($json->{'projects'} as $project) {
        
        $this->assertInternalType( "integer", $project->{'id'} );
        $this->assertInternalType( "string", $project->{'name'} );
        $this->assertInternalType( "string", $project->{'description'} );
        $this->assertInternalType( "string", $project->{'begin'} );
        $this->assertInternalType( "string", $project->{'end'} );
        $this->assertInternalType( "array", $project->{'tasks'} );
        $this->assertInternalType( "array", $project->{'users'} );
        
        $this->assertNull($project->{'users'});
        
        $this->assertFalse( date_create($project->{'begin'}) === FALSE );
        $this->assertFalse( date_create($project->{'end'}) === FALSE );
        
      }        
    }
    
    public function testGetProjectsUser()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/projects/1');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "array", $json->{'projects'}  );
      
      
      // Test wen it don't
      $crawler = $client->request('GET', '/api/projects/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'projects' ) );
	    
    }
    
    public function testGet()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/project/1');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'project'}  );
      
      // Then when it won't
      $crawler = $client->request('GET', '/api/project/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'project' ) );

    }
}
