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

class ChargeController extends Controller
{
    
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function listChargeAction(Request $request)
    {
    	$user = $this->get('security.context')->getToken()->getUser();
    	
    	$source = new SrcCharge('PlanITBundle:Assignment', $user);
    	
    	$grid = $this->get('grid');
    	$grid->setSource($source);
    	
    	$editColumn = new ActionsColumn('edit_column','Edit');
    	$editRowAction = new RowAction('Edit', 'PlanITBundle_editCharge');
    	$editRowAction->setColumn('edit_column');
    	$deleteColumn = new ActionsColumn('del_column','Delete');
    	$deleteRowAction = new RowAction('Delete', 'PlanITBundle_delCharge', true);
    	$deleteRowAction->setColumn('del_column');
    	$grid->addColumn($editColumn, -1);
    	$grid->addColumn($deleteColumn, -2);
        $grid->addRowAction($editRowAction);
        $grid->addRowAction($deleteRowAction);
    	
        return $this->render('PlanITBundle:Default:grid.html.twig', array('data' => $grid));
    }
    
    /**
    * @Secure(roles="ROLE_USER")
    */
	public function addChargeAction(Request $request, $idassignment = null)
    {
    	$em = $this->getDoctrine()->getEntityManager();

    	$user = $this->get('security.context')->getToken()->getUser();
    	
    	if (is_null($idassignment))
    		$charge	= new Assignment();
    	else
    		$charge = $this->getDoctrine()->getRepository("PlanITBundle:Assignment")->find($idassignment);
    		
    	
    	$form = $this->createForm(new AssignmentType($user), $charge);
    			
    	if ($request->getMethod() == 'POST')
    	{
    		$form->bindRequest($request);
    		if ($form->isValid() && !$form->isEmpty())
    		{   		
    			$em->persist($charge);
    			$em->flush();
    			
    			return new Response(json_encode(array('message' => 'Your project has been successfully saved')));
    		}
    		else 
    		{
    			$errors = $this->get('validator')->validate( $charge );
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
    			$action = $this->get("router")->generate('PlanITBundle_addCharge');
    		else
    			$action = $this->get("router")->generate('PlanITBundle_editCharge', array('idassignment'=>$idassignment));
    		
        	return $this->render('PlanITBundle:Default:charge.form.html.php', array('action'=>$action, 'form'=>$form->createView()));
    	}
    }
    
}
