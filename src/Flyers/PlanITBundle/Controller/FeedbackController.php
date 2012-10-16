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
use Flyers\PlanITBundle\Entity\Project;
use Flyers\PlanITBundle\Form\ProjectType;
use Flyers\PlanITBundle\Entity\Assignment;
use Flyers\PlanITBundle\Form\AssignmentType;
use Flyers\PlanITBundle\Entity\Job;
use Flyers\PlanITBundle\Form\JobType;
use Flyers\PlanITBundle\Entity\Person;
use Flyers\PlanITBundle\Form\PersonType;


class FeedbackController extends Controller
{

	const WORK_DAY_DURATION = 8;
	
	/**
    * @Secure(roles="ROLE_USER")
    */
	public function ganttFeedbackAction(Request $request, $idproject = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = $this->get('security.context')->getToken()->getUser();
    	
    	$projects = $em->getRepository("PlanITBundle:Project")->findAllByUser($user);
		
		
    	
		if ($request->getMethod() == 'POST')
    	{
    		$idproject = $request->request->get('idproject');
			
			if (!is_null($idproject))
	    	{
				return $this->redirect($this->generateUrl('PlanITBundle_ganttFeedback', array('idproject' => $idproject)));
			}
			else
	    	{
	    		return $this->render('PlanITBundle:Default:gantt.html.php', array("projects"=>$projects, "idproject" => $idproject));
	    	}
		}
		
		if (!empty($projects))
		{
			if ( $idproject == 0 )
				$idproject = $projects[0]->getIdproject();
		}
    	
        return $this->render('PlanITBundle:Default:gantt.html.php', array("projects"=>$projects, "idproject" => $idproject));
    }
    
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function pertFeedbackAction(Request $request, $idproject = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = $this->get('security.context')->getToken()->getUser();
    	
    	$projects = $em->getRepository("PlanITBundle:Project")->findAllByUser($user);
		
		$graph = NULL;
    	
    	if ($request->getMethod() == 'POST')
    	{
    		$idproject = $request->request->get('idproject');
			
			if (!is_null($idproject))
	    	{
				return $this->redirect($this->generateUrl('PlanITBundle_pertFeedback', array('idproject' => $idproject)));
			}
			else
	    	{
	    		return $this->render('PlanITBundle:Default:pert.html.php', array("projects"=>$projects, "idproject" => $idproject));
	    	}
		}
		
		if ( !empty($projects) ) {
			if ( $idproject == 0 )
				$idproject = $projects[0]->getIdproject();

			$project = $this->getDoctrine()->getRepository("PlanITBundle:Project")->find($idproject);
			
			$tasks = $em->getRepository("PlanITBundle:Assignment")->findAllByProject($idproject);
			
			$graph['begin'] = $project->getBegin()->format('r');
			$graph['end'] = $project->getEnd()->format('r');
			
			if ( count($tasks) > 0 )
			{
				$json_tasks = array();
				foreach( $tasks as $task ) {
					$json_tasks['id'] = $task->getIdassignment();
					$json_tasks['name'] = $task->getName();
					$json_tasks['duration'] = $task->getDuration();
					$json_tasks['parent'] = ( $task->getParent() ) ? $task->getParent()->getIdassignment() : NULL;
					
					$graph['tasks'][] = $json_tasks;
				}
			}
		}
		
      	return $this->render('PlanITBundle:Default:pert.html.php', array("projects"=>$projects, "idproject" => $idproject, "graphic" => json_encode($graph)));
    }
	
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function burndownFeedbackAction(Request $request, $idproject = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = $this->get('security.context')->getToken()->getUser();
		
		$projects = $em->getRepository("PlanITBundle:Project")->findAllByUser($user);
		
		$graph = NULL;
		
		if ($request->getMethod() == 'POST')
    	{
    		$idproject = $request->request->get('idproject');
			
			if (!is_null($idproject))
	    	{
				return $this->redirect($this->generateUrl('PlanITBundle_burndownFeedback', array('idproject' => $idproject)));
			}
			else
	    	{
	    		return $this->render('PlanITBundle:Default:burndown.html.php', array("projects"=>$projects, "idproject" => $idproject));
	    	}
		}

		if (!empty($projects))
		{
			if ( $idproject == 0 )
				$idproject = $projects[0]->getIdproject();

			$project = $this->getDoctrine()->getRepository("PlanITBundle:Project")->find($idproject);
	
			$tasks = $em->getRepository("PlanITBundle:Assignment")->findAllByProject($idproject);
			
			if ( count($tasks) > 0 )
			{
				$task_total_duration = 0;
				foreach($tasks as $task) {
					$graph_task = array();
					$task_duration = $task->getDuration();
					$task_total_duration += $task_duration;
				}
				$graph_task[] = array($project->getBegin()->format('Y-m-d H:i:s'), $task_total_duration);
				
				foreach($tasks as $task) {
					$charges = $em->getRepository("PlanITBundle:Charge")->findAllByAssignment($task);
					foreach ($charges as $charge) {
						$charge_total = $task_total_duration - $charge->getDuration();
						$graph_task[] = array($charge->getDate()->format('Y-m-d H:i:s'), $charge_total);
					}
				}
				$graph_task[] = array($project->getEnd()->format('Y-m-d H:i:s'), 0);
				
				$graph_project = array(array($project->getBegin()->format('Y-m-d H:i:s'), $task_total_duration),array($project->getEnd()->format('Y-m-d H:i:s'), 0));
				
				$graph = array($graph_task, $graph_project);
			}
		}
		
        return $this->render('PlanITBundle:Default:burndown.html.php', array("projects"=>$projects, "idproject" => $idproject, "graphic" => json_encode($graph)));
    }

	private function durationToInterval($duration) {
		$days = floor($duration);
		$hours_base10 = ( round($duration,2) - $days ) * self::WORK_DAY_DURATION;
		$hours = floor( $hours_base10 );
		$minutes = ( $hours_base10 - $hours ) * 60;
		
		$interval = new \DateInterval('P0Y'.$days.'DT'.$hours.'H'.$minutes.'M');
		return $interval;
	} 
   
}
