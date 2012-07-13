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
	public function burndownFeedbackAction(Request $request)
    {
        return $this->render('PlanITBundle:Default:feedback.html.php');
    }
   
}
