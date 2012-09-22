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
use Flyers\PlanITBundle\Entity\Assignment;
use Flyers\PlanITBundle\Form\AssignmentType;

define('WORK_DAY_DURATION', 8);
define('WORK_DAY_BEGINNING', 'T08H00M');

class TaskController extends Controller
{
	
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function listTaskAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
		
    	$user = $this->get('security.context')->getToken()->getUser();
		
		$tasks = $em->getRepository("PlanITBundle:Assignment")->findAllByUser($user); 
    	
        return $this->render('PlanITBundle:Default:task.list.html.php', array('tasks' => $tasks));
    }
    
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function addTaskAction(Request $request, $idassignment = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();

    	$user = $this->get('security.context')->getToken()->getUser();
    	
    	if (is_null($idassignment))
    		$task	= new Assignment();
    	else
    		$task = $this->getDoctrine()->getRepository("PlanITBundle:Assignment")->find($idassignment);
    		
    	$form = $this->createForm(new AssignmentType($user), $task);
    			
    	if ($request->getMethod() == 'POST')
    	{
    		$form->bindRequest($request);
    		if ($form->isValid() && !$form->isEmpty())
    		{
    			$preceeding = $task->getParent();
				$project = $task->getProject();
				if ( !is_null($preceeding) ) {
					$date_begin = $preceeding->getEnd();
					if ( !is_null($date_begin) ) {
						$task->setBegin($date_begin);
					}
				} else {
					$date_begin = $project->getBegin();
					$interval = new \DateInterval('P0Y0D'.WORK_DAY_BEGINNING);
					$date_begin->add($interval);
					$task->setBegin( $date_begin );
				}
				
				$duration = $task->getDuration();
				$days = floor($duration);
				$hours_base10 = ( round($duration,2) - $days ) * WORK_DAY_DURATION;
				$hours = floor( $hours_base10 );
				$minutes = ( $hours_base10 - $hours ) * 60;
				
				$interval = new \DateInterval('P0Y'.$days.'DT'.$hours.'H'.$minutes.'M');
				$date_end = clone $date_begin;
				$date_end->add($interval);
				$task->setEnd($date_end);
				
    			$em->persist($task);
    			$em->flush();
    			
    			$response = new Response(json_encode(array('message' => 'Your project has been successfully saved'))); 
				$response->headers->set('Content-Type', 'application/json');
				return $response;
    		}
    		else 
    		{
    			$errors = $this->get('validator')->validate( $task );
    			$ret = array();
    			foreach($errors as $error){
					$tmp["field"] = $error->getPropertyPath();
    				$tmp["message"] = $error->getMessage();
    				$ret[] = $tmp;
    			}
				
				$response = new Response(json_encode($ret)); 
				$response->headers->set('Content-Type', 'application/json');
				return $response;
    		}
    	}
    	else 
    	{
    		if ( is_null($idassignment))
    			$action = $this->get("router")->generate('PlanITBundle_addTask');
    		else
    			$action = $this->get("router")->generate('PlanITBundle_editTask', array('idassignment'=>$idassignment));
    		
        	return $this->render('PlanITBundle:Default:task.form.html.php', array('action'=>$action, 'form'=>$form->createView()));
    	}
    }
    
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function delTaskAction(Request $request, $idassignment = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$task = $em->getRepository("PlanITBundle:Assignment")->find($idassignment);
	    
    	if (!$task) {
	        throw $this->createNotFoundException('No task found for id '.$idassignment);
	    }
	    
	    $em->remove($task);
		$em->flush();
		
		$response = new Response(json_encode(array('message' => 'Task deleted with success'))); 
		$response->headers->set('Content-Type', 'application/json');
		return $response;
    }
}
