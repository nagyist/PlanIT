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
    	
    	$projects = $em->getRepository("PlanITBundle:Project")->findAllByUser($user)->getQuery()->getResult();
    	
    	$idproject = $request->query->get("idproject");
    	
    	if (is_null($idproject))
    	{
    		$idproject = 0;
    	}
    	
        return $this->render('PlanITBundle:Default:gantt.html.php', array("projects"=>$projects, "idproject" => $idproject));
    }
    
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function pertFeedbackAction(Request $request)
    {
        return $this->render('PlanITBundle:Default:feedback.html.php');
    }
   
	/**
    * @Secure(roles="ROLE_USER")
    */
	public function listFeedbackAction(Request $request, $idproject = null)
    {
		$vars = array();
		$cost = 0;
		$tthours = 0;
		$thours = 0;
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = $this->get('security.context')->getToken()->getUser();

    	$vars['projects'] = $em->getRepository("PlanITBundle:Project")->findAllByUser($user)->getQuery()->getResult();
		
    	if ( ! is_null($idproject))
    	{
	    	$project = $em->getRepository("PlanITBundle:Project")->find($idproject);
	    	
	    	$tasks = $em->getRepository("PlanITBundle:Assignment")->findAllByProject($idproject);
	    	$real_end = clone $project->getBegin();
	    	foreach($tasks as $task)
	    	{
	    		$time = $task->getBegin()->diff($task->getEnd());
	    		$real_end->add($time);
	    		
	    		$hours = $this->IntervalToHours($time);
	    		
	    		$cost += $hours*$em->getRepository("PlanITBundle:Assignment")->getSalaryForTask($task->getIdassignment());
	    		$tthours += $hours;
	    	}
	    	
	    	$thours = $this->IntervalToHours( $project->getBegin()->diff($project->getEnd()) );
	    	
	    	$vars['ntasks'] = $em->getRepository("PlanITBundle:Project")->countTasks($idproject);
	    	$vars['npersons'] = $em->getRepository("PlanITBundle:Project")->countPersons($idproject);
	    	$vars['pbegin'] = $project->getBegin()->format('Y-m-d');
	    	$vars['pend'] = $project->getEnd()->format('Y-m-d');
	    	$vars['tend'] = $real_end->format('Y-m-d');
	    	$vars['toccupy'] = intval( ($tthours/$vars['npersons']) * 100 / $thours);
	    	$vars['cost'] = $cost;
	    	
	    	return $this->render('PlanITBundle:Default:feedback.result.html.php', $vars);
    	}
    	else
    	{
    		return $this->render('PlanITBundle:Default:feedback.html.php', $vars);
    	}
        
    }
    
    private function IntervalToHours(\DateInterval $interval)
    {
    	$hours = 0;
    	if ( $interval->m > 0 )
    		$hours += $interval->m *30*24;
    	if ( $interval->d > 0 )
    		$hours += $interval->d * 24;
    	else
    		$hours += $interval->h;
    	return $hours;
    }
    
}
