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
use Flyers\PlanITBundle\Entity\Token;
use Flyers\PlanITBundle\Form\UserType;

class UserController extends Controller
{
 
 	private $DEFAULT_ROLE = "ROLE_USER";
	private $DEFAULT_FROM = "contact@flyers-web.org";
	
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
		
    	if ($request->getMethod() == 'POST')
    	{
    		$role = $em->getRepository("PlanITBundle:Role")->findOneByName($this->DEFAULT_ROLE);
			
			if (filter_var($username, FILTER_VALIDATE_EMAIL) !== FALSE )
			{ 
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
						
						$user->setActive(FALSE);
		    			
		    			$em->persist($user);
		    			$em->flush();
		    			
		    			$error = "User created successfully, check your inbox for further informations";
		    			
		    			$token = new Token();
						$token->setUser($user);
						
						$value = md5(time());
						
						$token->setValue($value);
						$em->persist($token);
		    			$em->flush();
		    			
		    			try {
				    		$message = \Swift_Message::newInstance()
										->setContentType('text/html')
				    					->setFrom($this->DEFAULT_FROM)
				    					->setSubject('PlanIT - validate your registration')
				    					->setTo($user->getUsername())
				    					->setBody('<h1>Validate your registration</h1><p>You registered yourself in the <a href="http://planit.flyers-web.org">PlanIT web site</a></p><p>Here is <a href="http://planit.flyers-web.org/validate/'.$value.'">the link</a> you should access for registration validation : http://planit.flyers-web.org/validate/'.$value.'</p><p>If you are not willing to be part of the PlanIT experience just ignore this email.</p>');
			    			$this->get('mailer')->send($message);
						} catch (Exception $e) {
							$error = "Unable to send confirmation email, please contact us at contact@flyers-web.org for help";
						}
						
						$message = \Swift_Message::newInstance()
									->setContentType('text/plain')
			    					->setFrom($this->DEFAULT_FROM)
			    					->setSubject('PlanIT - new registration')
			    					->setTo($this->DEFAULT_FROM)
			    					->setBody('New registration demand by '.$user->getUsername());
		    			$this->get('mailer')->send($message);
						
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
    		} else {
    			$error = "Username should be an email";
				return $this->render('PlanITBundle:Default:login.html.php', array('error'=>$error, 'form'=>$form->createView()));
    		}
    	}
    	return $this->render('PlanITBundle::index.html.php');
    }

	public function validateAction(Request $request, $tokenvalue = null)
    {
    	$error = null;
    	$em = $this->getDoctrine()->getEntityManager();
		
    	$token = $em->getRepository("PlanITBundle:Token")->findOneByValue($tokenvalue);

		if ( !is_null($token)) {
			
			$user = $token->getUser();
			
			$user->setActive(TRUE);
			
			$em->persist($user);
			$em->flush();
		
		} else {
			$error = "User not found";
		}
		
		return $this->render('PlanITBundle:Default:validate.html.php', array('error'=>$error));
		
	}
}
