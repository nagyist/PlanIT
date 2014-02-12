<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{

		private $id_job = 1;

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
      	
      	if(property_exists($job, 'description'))
      	$this->assertInternalType( "string", $job->{'description'} );

      	$this->assertFalse( property_exists($job, "employees"));
      	        
      }
      
      $client->insulate();
    }
        
    public function testGet()
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
            
      if( $json->{'error'} == "success" ) {
      
	      $jobs_length = count($json->{'jobs'});
	      
	      $job = $json->{'jobs'}[$jobs_length-1];
				
	      $this->{'id_job'} = $job->{'id'};
      
      }
      
      $client->insulate();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/job/'.$this->{'id_job'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'job'}  );
      
			$client->insulate();
      
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
      
      $client->insulate();

    }
    
    public function testCpost()
    {
    	$client = static::createClient();
    
    	$fields = array();
    
    	$crawler = $client->request('GET', '/api/jobs');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
			
			$job = new \stdClass();
			
      if( $json->{'error'} == "success" ) {
      
	      $jobs_length = count($json->{'jobs'});
	      
	      $job = $json->{'jobs'}[$jobs_length-1];
				
	      $this->{'id_job'} = $job->{'id'};
      
      }
      
      $client->insulate();
      
      // Test already existing job
      $fields["name"] = $job->{'name'};
      if (property_exists($job, 'description'))
      $fields["description"] = $job->{'description'};
      
      $crawler = $client->request('POST', 
												    '/api/job',
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
      
      // Test without description
      $fields["name"] = "Test Job";
      unset($fields["description"]);
      
      $crawler = $client->request('POST', 
												    '/api/job',
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode( $client->getResponse()->getContent() );
            
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      if ( $json->{'error'} == "success" )
      {
	      $job = $json->{'job'};
	      $client->request('DELETE', '/api/job/'.$job->{'id'});
      }
      
      $client->insulate();
      
      // Test OK
      $fields["description"] = "Test Job Description";
      
      $crawler = $client->request('POST', 
												    '/api/job',
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode( $client->getResponse()->getContent() );
            
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
			$client->insulate();
	    
    }
    
    public function testPut()
    {
    	$client = static::createClient();
    
    	$fields = array();
    
    	$crawler = $client->request('GET', '/api/jobs');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
			
      if( $json->{'error'} == "success" ) {
      
	      $jobs_length = count($json->{'jobs'});
	      
	      $job = $json->{'jobs'}[$jobs_length-1];
				
	      $this->{'id_job'} = $job->{'id'};
      
      }
      
      $client->insulate();
      
      // Test already existing job
      $fields["name"] = $job->{'name'};
      
      if (property_exists($job, 'description'))
      $fields["description"] = $job->{'description'};
      
      $crawler = $client->request('PUT', 
												    '/api/job/'.$this->{'id_job'},
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
      
      // Test without description
      $fields["name"] = "Test Job #1";
      unset($fields["description"]);
      
      $crawler = $client->request('PUT', 
												    '/api/job/'.$this->{'id_job'},
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode( $client->getResponse()->getContent() );
            
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      if ( $json->{'error'} == "success" )
      {
	      $job = $json->{'job'};
	      
	      $client->request('DELETE', '/api/employee/'.$job->{'id'});
      }
      
      $client->insulate();
      
      // Test OK
      $fields["name"] = "Test Job #2";
      $fields["description"] = "Test Job Description";
      
      $crawler = $client->request('PUT', 
												    '/api/job/'.$this->{'id_job'},
												    $fields,
												    array(),
												    array('Content-Type' => 'application/json'));
												    
			$this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode( $client->getResponse()->getContent() );
            
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
			$client->insulate();
	    
    }
    
    public function testDelete()
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
			
      if( $json->{'error'} == "success" ) {
      
	      $jobs_length = count($json->{'jobs'});
	      
	      $job = $json->{'jobs'}[$jobs_length-1];
				
	      $this->{'id_job'} = $job->{'id'};
      
      }
      
      $client->insulate();
	    
	    //Test when it don't work
	    $crawler = $client->request('DELETE', '/api/job/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
            
      $client->insulate();
	    
	    
	    // Test when it works
	    $crawler = $client->request('DELETE', '/api/job/'.$this->{'id_job'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      					      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
            
      $client->insulate();
	    
    }
}
