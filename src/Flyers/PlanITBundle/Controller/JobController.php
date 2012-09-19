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
use Flyers\PlanITBundle\Entity\Job;
use Flyers\PlanITBundle\Form\JobType;

class JobController extends Controller
{
    
    /**
    * @Secure(roles="ROLE_USER")
    */
    public function addJobAction(Request $request, $idjob = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
   		if (is_null($idjob))
    		$job = new Job();
    	else
			$job = $this->getDoctrine()->getRepository("PlanITBundle:Job")->find($idjob);
    	
    	$form = $this->createForm(new JobType(), $job);
    	
    	if ($request->getMethod() == 'POST')
    	{
    		$form->bindRequest($request);
    		
    		if ($form->isValid() && !$form->isEmpty())
    		{
    			
    			$em->persist($job);
    			$em->flush();
    			
				$response = new Response(json_encode(array('message' => 'The job has been successfully created'))); 
				$response->headers->set('Content-Type', 'application/json');
				return $response;
    		}
    		else
    		{
    			$errors = $this->get('validator')->validate( $job );
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
    		if ( is_null($idjob))
    			$action = $this->get("router")->generate('PlanITBundle_addJob');
    		else
    			$action = $this->get("router")->generate('PlanITBundle_editJob', array('idjob'=>$idjob));
    			
    		return $this->render('PlanITBundle:Default:job.form.html.php', array('action'=>$action, 'form'=>$form->createView()));
    	}
    }
    
}
