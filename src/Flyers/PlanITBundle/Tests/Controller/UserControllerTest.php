<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCGet()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/api/users');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $this->assertInternalType( "array", $json->{'users'}  );
      
      foreach($json->{'users'} as $user) {
        
        $this->assertInternalType( "integer", $user->{'id'} );
        $this->assertInternalType( "string", $user->{'username'} );
        $this->assertInternalType( "string", $user->{'email'} );
        $this->assertInternalType( "boolean", $user->{'enabled'} );
        $this->assertInternalType( "string", $user->{'password'} );
        $this->assertInternalType( "boolean", $user->{'expired'} );
        $this->assertInternalType( "array", $user->{'roles'} );                      
        
        $this->assertFalse( property_exists( $user, 'projects' ) );
        $this->assertFalse( property_exists( $user, 'employees' ) );        
        
        $this->assertTrue( $user->{'enabled'}, $user->{'username'} );
        $this->assertFalse( $user->{'expired'} );
                
      }        
    }
        
    public function testGet()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/user/1');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'user'}  );
      
      // Then when it won't
      $crawler = $client->request('GET', '/api/user/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
      
      $this->assertFalse( property_exists( $json, 'user' ) );

    }
}
