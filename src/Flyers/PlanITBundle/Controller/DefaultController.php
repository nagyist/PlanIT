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
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

use JMS\SecurityExtraBundle\Annotation\Secure;


class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        return $this->render('PlanITBundle::index.html.php');
    }
    
	public function planitAction(Request $request)
    {
        return $this->render('PlanITBundle:Default:planit.html.php');
    }
    
    public function contactAction(Request $request)
    {
    	
		$collectionConstraint = new Collection(array(
		    'name' => new MinLength(1),
		    'email' => new Email(array('message' => 'Invalid email address')),
		    'subject' => new MinLength(1),
		    'message' => new MinLength(1),
		));
		
    	$defaultData = array();
		$form = $this->createFormBuilder($defaultData, array(
						    'validation_constraint' => $collectionConstraint,
						))
				        ->add('name', 'text')
				        ->add('email', 'email')
						->add('subject', 'text')
				        ->add('message', 'textarea')
				        ->getForm();
		
    	if ($request->getMethod() == 'POST')
    	{
    		
			$form->bindRequest($request);
			
			$data = $form->getData();
			
			try {
	    		$message = \Swift_Message::newInstance()
	    					->setFrom($data['email'])
	    					->setSubject($data['subject'])
	    					->setTo('contact@flyers-web.org')
	    					->setBody($data['name']."<br />".$data['message']);
    			$this->get('mailer')->send($message);
			} catch (Exception $e) {
				$e->getMessage();
			}
    		
			$return = "Message envoyé avec succès";
			$response = new Response(json_encode($return));
	    	$response->headers->set('Content-Type', 'application/json');
	    	return $response;
    	}
    	else 
		{
			
    		return $this->render('PlanITBundle:Default:contact.html.php', array('form'=>$form->createView()));
		}
    }
    
	public function donateAction(Request $request)
    {
    	return $this->render('PlanITBundle:Default:donate.html.php');
    }
	
	public function aboutAction(Request $request)
    {
    	return $this->render('PlanITBundle:Default:about.html.php');
    }
}
