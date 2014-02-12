<?php

namespace Flyers\PlanITBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

use Flyers\PlanITBundle\Entity\User;
use Flyers\PlanITBundle\Entity\Project;
use Flyers\PlanITBundle\Entity\Employee;
use Flyers\PlanITBundle\Entity\Charge;
use Flyers\PlanITBundle\Form\ProjectType;
use Flyers\PlanITBundle\Form\EmployeeType;
use Flyers\PlanITBundle\Form\ChargeType;


class ChargeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/api/charges")
     */
    public function cgetAction()
    {
        $em = $this->container->get("doctrine")->getManager();
        
        $entities = $em->getRepository("PlanITBundle:Charge")->findAll();

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'charges' => $entities
            ), 200);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/charges/{slug}")
     */
    public function getChargesTaskAction($slug)
    {
        $em = $this->container->get("doctrine")->getManager();

        $id = intval($slug);

        if ($id <= 0)
        {
            $view = $this->view(array(
                    'error' => 'error',
                    'message' => 'Invalid Task'
                ), 200);
            return $this->handleView($view);
        }

        $task = $em->getRepository("PlanITBundle:Task")->find($slug);
        if (!$task)
        {
            $view = $this->view(array(
                    'error' => 'error',
                    'message' => 'No Task Found !'
                ), 200);
            return $this->handleView($view);
        }

        $entities = $em->getRepository("PlanITBundle:Charge")->findByTask($task);

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'charges' => $entities
            ), 200);
        return $this->handleView($view);

    }

    /**
     * @Rest\Get("/api/charge/{id}")
     */
    public function getAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();

        $entity = $em->getRepository("PlanITBundle:Charge")->find($id);
        if (!$entity) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Charge not found !'
                ), 200);
            return $this->handleView($view);
        }

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'charge' => $entity
            ), 200);
        return $this->handleView($view);

    }

    /**
     * params: name,description,begin,end,user
     * @Rest\Post("/api/charge")
     */
    public function cpostAction(Request $request)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Charge');

        $entity = new Charge();
        $form = $this->createForm(new ChargeType(), $entity);

        $data = array();

        $projectId = intval($request->request->get('project'));
        $taskId = intval($request->request->get('task'));
        $employeeId = intval($request->request->get('employee'));


        $data["created"] = $request->request->get('created');
        $data["description"] = $request->request->get('description');

				$data["duration"] = $request->request->get('duration');
				
				if ($data["duration"]) $data["duration"] = floatval( $data["duration"] );

        if ( ( strpos($request->request->get('duration'), 'h') ) !== FALSE )
            $base = 1;
        if ( ( strpos($request->request->get('duration'), 'd') ) !== FALSE )
            $base = 2;
        if ( ( strpos($request->request->get('duration'), 'm') ) !== FALSE )
            $base = 3;

        $data["duration"] = $entity->convertDuration($data["duration"], $base);

        $employee = $em->getRepository("PlanITBundle:Employee")->find($employeeId);
        if (!$employee) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Employee not found !'
                ), 200);
            return $this->handleView($view);
        }

        $task = $em->getRepository("PlanITBundle:Task")->find($taskId);
        if (!$task) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Task not found !'
                ), 200);
            return $this->handleView($view);
        }

        $form->bind($data);

        if ($form->isValid()) {
            $entity->setEmployee($employee);
            $entity->setTask($task);
            $em->persist($entity);
            $em->flush();

            $view = $this->view(array(
                'error' => 'success',
                'message' => 'Charge saved with success',
                'charge' => $entity
                ), 200);
            return $this->handleView($view);
        } else {
            $view = $this->view(array(
                'error' => 'error',
                'message' => $form->getErrorsAsString()
                ), 200);
            return $this->handleView($view);
        }

    }

    /**
     * @Rest\Delete("/api/charge/{id}")
     * @Rest\View()
     */
    public function deleteAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Charge');
        
        $entity = $entityRepository->find($id);

        if (is_null($entity))
        {
        	$view = $this->view(array(
	            'error' => 'error',
	            'message' => 'Charge not found !'
	            ), 200);
	        return $this->handleView($view);
        }
        
        $em->remove($entity);
        $em->flush();

        $view = $this->view(array(
            'error' => 'success',
            'message' => 'Charge deleted with success'
            ), 200);
        return $this->handleView($view);
    }


}