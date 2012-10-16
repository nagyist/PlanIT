<?php

/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
  
 * Copyright 2012 BEN GHMISS Nassim 
 * 
 */

namespace Flyers\PlanITBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Flyers\PlanITBundle\Entity\Role;
use Flyers\PlanITBundle\Entity\User;
use Flyers\PlanITBundle\Form\UserType;
use Flyers\PlanITBundle\Entity\Project;
use Flyers\PlanITBundle\Form\ProjectType;
use Flyers\PlanITBundle\Entity\Assignment;
use Flyers\PlanITBundle\Form\AssignmentType;
use Flyers\PlanITBundle\Entity\Job;
use Flyers\PlanITBundle\Form\JobType;
use Flyers\PlanITBundle\Entity\Person;
use Flyers\PlanITBundle\Form\PersonType;

class APIController extends Controller
{
    
	public function listCalEventsAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$return = array();
    	
    	$colors = array("blue","green","red","black","yellow");
    	
    	$user = $this->get('security.context')->getToken()->getUser();
    	$projects = $em->getRepository("PlanITBundle:Project")->findAllByUser($user);
    	
    	$idx = 0;
    	foreach( $projects as $project )
    	{
    		
    		$tasks = $em->getRepository("PlanITBundle:Assignment")->findAllByProject($project->getIdproject());
    		
    		foreach ($tasks as $task)
    		{
    			$description = $task->getDescription();
				$title = "Project : ".$task->getProject()->getName()."\nTask : ".$task->getName()."\n\n".$description;
				$tooltip = "<p>Previsted beginning : ".$task->getBegin()->format("d-m-Y H:i")."</p><p>Previsted end : ".$task->getEnd()->format("d-m-Y H:i")."</p>";
				
	    		$vals["id"]				= $task->getIdassignment();
	    		$vals["title"] 			= $title;
	    		$vals["tooltip"] 		= $tooltip ;
	    		$vals["start"] 			= $task->getBegin()->format('Y-m-d H:i');
	    		$vals["end"]   			= $task->getEnd()->format('Y-m-d H:i');
	    		$vals["color"]  		= $colors[$idx];
	    		$vals["allDay"] 		= false;
	    		
	    		$return[] = $vals;
	    		
    		}
    		
    		$idx++;
    	}    	
    	
    	$response = new Response(json_encode($return));
    	$response->headers->set('Content-Type', 'application/json');
    	return $response;
    }
    	
    public function listGanttEventsAction(Request $request, $idproject = null)
    {
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	$return = array();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$tasks = $em->getRepository("PlanITBundle:Assignment")->findAllByProject($idproject);
    	
    	foreach ($tasks as $task)
    	{
    		$date_begin = $task->getBegin()->getTimestamp()+$task->getBegin()->getOffset();
			$date_end = $task->getEnd()->getTimestamp()+$task->getEnd()->getOffset();
    		$vals = array();
    		$vals["name"] = $task->getName();
    		$vals["values"] = array();
    		$vals["values"][0]["label"] = $task->getName();
    		$vals["values"][0]["desc"] = $task->getDescription();
    		$vals["values"][0]["from"] = "/Date(".$date_begin."000)/";
    		$vals["values"][0]["to"]   = "/Date(".$date_end."000)/";
    		$return[] = $vals;
    	}

    	$response = new Response(json_encode($return));
    	$response->headers->set('Content-Type', 'application/json');
    	return $response;
    }
    
	public function editCalDropEventsAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$task = $em->getRepository("PlanITBundle:Assignment")->find($request->request->get('id'));
    	
    	$begin 	= new \DateTime( $request->request->get('start') );
    	$end 	= new \DateTime( $request->request->get('end') );
    	
    	$task->setBegin($begin);
    	$task->setEnd($end);
    	
    	$em->flush();
    	
    	return new Response();
    }
    
	public function editCalResizeEventsAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$task = $em->getRepository("PlanITBundle:Assignment")->find($request->request->get('id'));
    	
    	$end = new \DateTime( $request->request->get('end') );
    	
    	$task->setEnd($end);
    	
    	$em->flush();
    	
    	return new Response();
    }
}
