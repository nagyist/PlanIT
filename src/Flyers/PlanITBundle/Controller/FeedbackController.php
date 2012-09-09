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
  
 * � Copyright 2012 BEN GHMISS Nassim �  
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
    	
    	if (is_null($idproject))
    	{
    		return $this->redirect($this->generateUrl('PlanITBundle_homepage'));
    	}
		
		
		
        return $this->redirect($this->generateUrl('PlanITBundle_homepage'));
    }
	
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function burndownFeedbackAction(Request $request, $idproject = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = $this->get('security.context')->getToken()->getUser();
		
		$projects = $em->getRepository("PlanITBundle:Project")->findAllByUser($user);
		
		
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

		$project = $this->getDoctrine()->getRepository("PlanITBundle:Project")->find($idproject);
		
		$graph = array();
		
		$tasks = $em->getRepository("PlanITBundle:Assignment")->findAllByProject($idproject);
		if ( count($tasks) > 0 )
		{
			$task_iterator = $tasks[0]->getBegin();
			$task_begin = clone $task_iterator;
			foreach($tasks as $task) {
				$graph_task = array();
				$diff_task = $task->getBegin()->diff($task->getEnd());
				$task_iterator->add($diff_task);
				$total_estimated = $task_begin->diff($task_iterator);
				$total_estimated_charge = $total_estimated->h + $total_estimated->days *24;
				$graph_task[] = array($task_begin->format('Y-m-d H:i:s'), $total_estimated_charge);
			}
			
			foreach($tasks as $task) {
				$charges = $em->getRepository("PlanITBundle:Charge")->findAllByAssignment($task);
				$charge_begin = clone $task_iterator;
				foreach ($charges as $charge) {
					$diff_charge = $charge->getBegin()->diff($charge->getEnd());
					$task_iterator->sub($diff_charge);
					$total_done = $charge_begin->diff($task_iterator);
					$total_charge = $total_estimated_charge - ($total_done->h + $total_done->days * 24);
					
					$graph_task[] = array($charge->getBegin()->format('Y-m-d H:i:s'), $total_charge);
				}
			}
			
			$graph[] = $graph_task;
		}
		$graph_json = json_encode($graph);
		
        return $this->render('PlanITBundle:Default:burndown.html.php', array("projects"=>$projects, "idproject" => $idproject, "graphic" => $graph_json));
    }
   
}
