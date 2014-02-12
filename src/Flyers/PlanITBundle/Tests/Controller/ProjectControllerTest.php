<?php

namespace Flyers\PlanITBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{

		private $id_project = 1;
		private $id_user 		= 1;

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
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $this->assertInternalType( "array", $json->{'projects'}  );
      
      foreach($json->{'projects'} as $project) {
        
        $this->assertInternalType( "integer", $project->{'id'} );
        $this->assertInternalType( "string", $project->{'name'} );
        
        if (property_exists($project, 'description'))
        $this->assertInternalType( "string", $project->{'description'} );
        $this->assertInternalType( "string", $project->{'begin'} );
        $this->assertInternalType( "string", $project->{'end'} );
        $this->assertFalse( property_exists($project, 'tasks') );
        
				$this->assertFalse( property_exists($project, 'users') );
        
        $this->assertFalse( date_create($project->{'begin'}) === FALSE );
        $this->assertFalse( date_create($project->{'end'}) === FALSE );
        
      }        
    }
    
    public function testGetProjectsUser()
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
	    $crawler = $client->request('GET', '/api/projects/'.$this->{'id_user'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "array", $json->{'projects'}  );
      
      $client->insulate();
      
      
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
      
      $client->insulate();
	    
    }
    
    public function testGet()
    {
	    $client = static::createClient();
	    
	    $crawler = $client->request('GET', '/api/projects');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $projects_length = count($json->{'projects'});
      
      $project = $json->{'projects'}[$projects_length-1];
			
      $this->{'id_project'} = $project->{'id'};
      
			$client->insulate();
	    
	    // Test when it works
	    $crawler = $client->request('GET', '/api/project/'.$this->{'id_project'});
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "success", $json->{'message'} );
      
      $this->assertInternalType( "object", $json->{'project'}  );
      
      $client->insulate();
      
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
	    
	    
	    // Test without datas
	    $crawler = $client->request('POST', 
												    '/api/project',
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
      
      // Test without begin / end
      $fields["user"] 		= $this->{'id_user'};
      $fields["name"] 		= "Test Project";
      $fields["description"] = "Test Project";
      
	    $crawler = $client->request('POST', 
												    '/api/project',
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
      
      
      // Test success
      $begin = new \DateTime();
      $end = new \DateTime();
      $end->add( new \DateInterval("P15D") );
	    
	    $fields["begin"] = $begin->format("d/m/Y");
	    $fields["end"] 	 = $end->format("d/m/Y");	    
	    
	    $crawler = $client->request('POST', 
												    '/api/project',
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
      
      $project = $json->{'project'};
      
      $this->assertInternalType( "integer", $project->{'id'} );
      $this->assertInternalType( "string", $project->{'name'} );
      $this->assertInternalType( "string", $project->{'description'} );
      $this->assertInternalType( "string", $project->{'begin'} );
      $this->assertInternalType( "string", $project->{'end'} );
      
      $this->assertFalse( property_exists($project, 'tasks') );
      $this->assertFalse( property_exists($project, 'users') );
      
      $this->assertFalse( date_create($project->{'begin'}) === FALSE );
      $this->assertFalse( date_create($project->{'end'}) === FALSE );
      
      $this->{'id_project'} = $project->{'id'};
            
      $client->insulate();
	    
    }
    
    public function testPut()
    {
	    $client = static::createClient();
	    
	    $crawler = $client->request('GET', '/api/projects');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      $this->assertEquals( $json->{'error'}, "success" );
      
      $projects_length = count($json->{'projects'});
      
      $project = $json->{'projects'}[$projects_length-1];
			
      $this->{'id_project'} = $project->{'id'};
      
			$client->insulate();
	    
	    // Test without datas
	    $fields = array();
	    	    
	    $crawler = $client->request('PUT', 
												    '/api/project/'.$this->{'id_project'},
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
      
      // Test without begin / end
      $fields["user"] 		= 1;
      $fields["name"] 		= "Test Project";
      $fields["description"] = "Test Project";
      
	    $crawler = $client->request('PUT', 
												    '/api/project/'.$this->{'id_project'},
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
      
      // Test success
      $begin = new \DateTime();
      $end = new \DateTime();
      $end->add( new \DateInterval("P15D") );
	    
	    $fields["begin"] = $begin->format("d/m/Y");
	    $fields["end"] 	 = $end->format("d/m/Y");	    
	    
	    $crawler = $client->request('PUT', 
												    '/api/project/'.$this->{'id_project'},
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
      
      $project = $json->{'project'};
      
      $this->assertInternalType( "integer", $project->{'id'} );
      $this->assertInternalType( "string", $project->{'name'} );
      $this->assertInternalType( "string", $project->{'description'} );
      $this->assertInternalType( "string", $project->{'begin'} );
      $this->assertInternalType( "string", $project->{'end'} );
      
      $this->assertFalse( property_exists($project, 'tasks') );
      $this->assertFalse( property_exists($project, 'users') );
      
      $this->assertFalse( date_create($project->{'begin'}) === FALSE );
      $this->assertFalse( date_create($project->{'end'}) === FALSE );
            
      $client->insulate();

    }
    
    public function testDelete()
    {
	    $client = static::createClient();
	    
	    $crawler = $client->request('GET', '/api/projects');
      
      $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertNotNull($json, $client->getResponse()->getContent());
            
      if( $json->{'error'} == "success" ) {
      
	      $projects_length = count($json->{'projects'});
	      
	      $project = $json->{'projects'}[$projects_length-1];
				
	      $this->{'id_project'} = $project->{'id'};
      
      }
      
			$client->insulate();
	    
	    //Test when it don't work
	    $crawler = $client->request('DELETE', '/api/project/0');
	    
	    $this->assertTrue(
      						$client->getResponse()->headers->contains(
      							'Content-Type', 'application/json'
      						)
      					);
      
      $json = json_decode($client->getResponse()->getContent());
      
      $this->assertEquals( $json->{'error'}, "error", $json->{'message'} );
            
      $client->insulate();
	    
	    
	    // Test when it works
	    $crawler = $client->request('DELETE', '/api/project/'.$this->{'id_project'});
	    
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
