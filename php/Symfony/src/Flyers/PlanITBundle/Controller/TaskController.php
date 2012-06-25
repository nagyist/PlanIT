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
use Flyers\PlanITBundle\Form\UserType;
use Flyers\PlanITBundle\Entity\Assignment;
use Flyers\PlanITBundle\Form\AssignmentType;

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
    	
        return $this->render('PlanITBundle:Default:task.list.html.php', array('tasks', $tasks));
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
    			$em->persist($task);
    			$em->flush();
    			
    			return new Response(json_encode(array('message' => 'Your project has been successfully saved')));
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
    			return new Response( json_encode($ret) );
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
    	
    	$task = $em->getRepository("PlanITBundle:Project")->find($idassignment);
	    
    	if (!$task) {
	        throw $this->createNotFoundException('No product found for id '.$idassignment);
	    }
	    
	    $em->remove($task);
		$em->flush();
		
		return new Response('');
    }
}
