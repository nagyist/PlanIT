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
//use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Flyers\PlanITBundle\Entity\Role;
use Flyers\PlanITBundle\Entity\User;
use Flyers\PlanITBundle\Form\UserType;
use Flyers\PlanITBundle\Entity\Project;
use Flyers\PlanITBundle\Form\ProjectType;

class ProjectController extends Controller
{
    
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function listProjectAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
		
    	$user = $this->get('security.context')->getToken()->getUser();
		
		$projects = $em->getRepository("PlanITBundle:Project")->findAllByUser($user); 
    	
        return $this->render('PlanITBundle:Default:project.list.html.php', array("projects", $projects));
    }
    
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function delProjectAction(Request $request, $idproject = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$project = $em->getRepository("PlanITBundle:Project")->find($idproject);
	    
    	if (!$project) {
	        throw $this->createNotFoundException('No product found for id '.$idproject);
	    }
	    
	    $em->remove($project);
		$em->flush();
		
		return new Response('');
    }
    
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function addProjectAction(Request $request, $idproject = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = $this->get('security.context')->getToken()->getUser();
    	
    	if (is_null($idproject))
    		$project = new Project();
    	else
    		$project = $em->getRepository("PlanITBundle:Project")->find($idproject);
    		
		$form = $this->createForm(new ProjectType($user), $project);
		
    	if ($request->getMethod() == 'POST')
    	{
    		$form->bindRequest($request);
    		
    		$project->setUser( $this->get('security.context')->getToken()->getUser() );
    		var_dump($form);
    		
    		if ($form->isValid() && !$form->isEmpty())
    		{
    			$em->persist($project);
    			$em->flush();
    			return new Response(json_encode(array('message' => 'Your project has been successfully saved')));
    		}
    		else
    		{
    			$errors = $this->get('validator')->validate( $project );
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
    		if ( is_null($idproject))
    			$action = $this->get("router")->generate('PlanITBundle_addProject');
    		else
    			$action = $this->get("router")->generate('PlanITBundle_editProject', array('idproject'=>$idproject));
        	
    		return $this->render('PlanITBundle:Default:project.form.html.php', array('action'=>$action, 'form'=>$form->createView()));
    	}
    }
}
