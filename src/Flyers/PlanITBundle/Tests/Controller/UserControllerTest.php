<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

		private $id_user = 1;

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
        
//        $this->assertTrue( $user->{'enabled'}, $user->{'username'} );
        $this->assertFalse( $user->{'expired'} );
                
      }        
    }
        
    public function testGet()
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
	    $crawler = $client->request('GET', '/api/user/'.$this->{'id_user'});
	    
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
    
    public function authTest()
    {
	    $client = static::createClient();
	    
	    $fields = array();
	    
	    // Test with empty data
	    $crawler = $client->request('POST', 
												    '/user/auth',
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
	    
	    // Test with inexistant user
	    $fields['email'] = "john.doe";
	    $fields['password'] = "john.doe";
	    
	    $crawler = $client->request('POST', 
												    '/user/auth',
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
	    
	    // Test working	    
	    $fields['email'] = "test@test.com";
	    $fields['password'] = "test";
	    
	    $crawler = $client->request('POST', 
												    '/user/auth',
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
      $this->assertFalse( property_exists($json, 'token') );
      
      $client->insulate();
    }
    
    public function testCreate()
    {
	    $client = static::createClient();
	    
	    $fields = array();
	    
	    
	    // Test without data
	    $crawler = $client->request('POST', 
												    '/user/create',
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
      
      // Test with unvalid password confirmation
      $fields["email"] = "john.doe@doe.com";
      $fields["password"] = "john.doe";
      $fields["password_confirm"] = "john.doe.";
            
      $crawler = $client->request('POST', 
												    '/user/create',
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
      
      // Test with unvalid email
      $fields["email"] = "john.doe";
      $fields["password"] = "john.doe";
      $fields["password_confirm"] = "john.doe";
            
      $crawler = $client->request('POST', 
												    '/user/create',
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
      
      
      // Test with valid data
      $fields["email"] = "john.doe@doe.com";
      
      $crawler = $client->request('POST', 
												    '/user/create',
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
      $this->assertTrue( property_exists($json, 'user') );
      
      $client->insulate();
    }
}
