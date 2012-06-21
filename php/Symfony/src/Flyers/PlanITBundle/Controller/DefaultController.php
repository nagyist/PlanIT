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
  
 * « Copyright 2012 BEN GHMISS Nassim »  
 * 
 */

namespace Flyers\PlanITBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
    	if ($request->getMethod() == 'POST')
    	{
    		$message = \Swift_Message::newInstance()
    					->setFrom($request->request->get('email'))
    					->setSubject($request->request->get('subject'))
    					->setTo('contact@flyers-web.org')
    					->setBody($request->request->get('name')."<br />".$request->request->get('message'));
    		;
    		$this->get('mailer')->send($message);
    		
    		return new Response();
    	}
    	else 
    		return $this->render('PlanITBundle:Default:contact.html.php');
    }
    
	public function aboutAction(Request $request)
    {
    	return $this->render('PlanITBundle:Default:about.html.php');
    }
}
