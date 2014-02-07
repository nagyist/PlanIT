<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChargeControllerTest extends WebTestCase
{
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
      	$this->assertInternalType( "string", $charge->{'description'} );
      	$this->assertInternalType( "float", $charge->{'duration'} );
      	$this->assertInternalType( "string", $charge->{'created'} );
      	$this->assertInternalType( "object", $charge->{'employee'} );
      	$this->assertInternalType( "object", $charge->{'task'} );      	
      	
        $this->assertFalse( date_create($charge->{'created'}) === FALSE );
        
      }        
    }
    
    public function testGetChargesTask()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/charges/11');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "array", $json->{'charges'}  );
      
      
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
	    
    }
    
    public function testGet()
    {
	    $client = static::createClient();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/charge/1');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'charge'}  );
      
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

    }
}
