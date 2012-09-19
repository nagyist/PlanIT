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
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Flyers\PlanITBundle\Entity\Role;
use Flyers\PlanITBundle\Entity\User;
use Flyers\PlanITBundle\Form\UserType;

class UserController extends Controller
{
 
	public function loginAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = new User();
    	
    	$session = $request->getSession();
    	
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
    	
    	$form = $this->createForm(new UserType(), $user);
    	
		if ( isset($error) )
			$params = array('error'=>$error->getMessage(), 'form'=>$form->createView());
		else
			$params = array('form'=>$form->createView());
        return $this->render('PlanITBundle:Default:login.html.php', $params);
        
    }
    public function logoutAction(Request $request)
    {
    	return $this->redirect($this->generateUrl('PlanITBundle_index'));
    }
    
    public function registerAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
		
		$user = new User();
		$form = $this->createForm(new UserType(), $user);
		
		$username = $request->request->get('_username');
    	$password = $request->request->get('_password');
    	$confirm = $request->request->get('confirm');
		
		$factory = $this->container->get('security.encoder_factory');
		
		if ( $username != 'nassim.benghmiss@gmail.com') {
			$error = "Registrations not allowed for the moment";
			return $this->render('PlanITBundle:Default:login.html.php', array('error'=>$error, 'form'=>$form->createView()));
		}
		
    	if ($request->getMethod() == 'POST')
    	{
    		$role = $em->getRepository("PlanITBundle:Role")->find(1);

    		if ( is_null($em->getRepository("PlanITBundle:User")->findOneByUsername($username) ) )
    		{
    			if ( $password == $confirm )
				{
					$user->getUserRoles()->add($role);
					
					$user->setUsername($username);
		    		$user->setSalt(md5(time()));
					$user->setPassword($password);
					
	    			$encoder = $factory->getEncoder($user);
	    			$password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
					
					$user->setPassword($password);
	    			
	    			$em->persist($user);
	    			$em->flush();
					
					$error = "User created successfully";
					return $this->render('PlanITBundle:Default:login.html.php', array('error'=>$error, 'form'=>$form->createView()));
				}
				else {
					$error = "Password confirmation is invalid";
					return $this->render('PlanITBundle:Default:login.html.php', array('error'=>$error, 'form'=>$form->createView()));
				}
    		} else {
    			$error = "Username already taked";
				return $this->render('PlanITBundle:Default:login.html.php', array('error'=>$error, 'form'=>$form->createView()));
    		}
    	}
    	return $this->render('PlanITBundle::index.html.php');
    }
}
