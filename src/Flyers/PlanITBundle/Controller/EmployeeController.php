<?php

namespace Flyers\PlanITBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

use Flyers\PlanITBundle\Entity\User;
use Flyers\PlanITBundle\Entity\Employee;
use Flyers\PlanITBundle\Form\EmployeeType;

class EmployeeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/api/employees")
     */
    public function cgetAction()
    {
        $em = $this->container->get("doctrine")->getManager();
        
        $entities = $em->getRepository("PlanITBundle:Employee")->findAll();

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'employees' => $entities
            ), 200);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/employees/{slug}")
     */
    public function getEmployeesUserAction($slug)
    {
        $em = $this->container->get("doctrine")->getManager();

        $id = intval($slug);

        if ($id <= 0)
        {
            $view = $this->view(array(
                    'error' => 'error',
                    'message' => 'Invalid User'
                ), 200);
            return $this->handleView($view);
        }

        $user = $em->getRepository("PlanITBundle:User")->find($slug);
        if (!$user)
        {
            $view = $this->view(array(
                    'error' => 'error',
                    'message' => 'No User Found !'
                ), 200);
            return $this->handleView($view);
        }

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'employees' => $user->getEmployees()
            ), 200);
        return $this->handleView($view);

    }

    /**
     * @Rest\Get("/api/employee/{id}")
     */
    public function getAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();

        $entity = $em->getRepository("PlanITBundle:Employee")->find($id);
        if (!$entity) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Employee not found !'
                ), 200);
            return $this->handleView($view);
        }

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'employee' => $entity
            ), 200);
        return $this->handleView($view);

    }

    /**
     * params: name,description,begin,end,user
     * @Rest\Post("/api/employee")
     */
    public function cpostAction(Request $request)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Employee');

        $entity = new Employee();
        $form = $this->createForm(new EmployeeType(), $entity);
        
        $data = array();

        $userId = intval($request->request->get('user'));
        $jobId = intval($request->request->get('job'));
        $data["lastname"] = $request->request->get('lastname');
        $data["firstname"] = $request->request->get('firstname');
        $data["email"] = $request->request->get('email');
        $data["phone"] = $request->request->get('phone');
        $data["salary"] = floatval( $request->request->get('salary') );
        
        $employee = $em->getRepository("PlanITBundle:Employee")->findByEmail($data["email"]);
        if ($employee)
        {
	        $view = $this->view(array(
                'error' => 'error',
                'message' => 'Employee already exists !'
                ), 200);
            return $this->handleView($view);
        }

        $user = $em->getRepository("PlanITBundle:User")->find($userId);
        if (!$user) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'User not found !'
                ), 200);
            return $this->handleView($view);
        }

        $job = $em->getRepository("PlanITBundle:Job")->find($jobId);
        if (!$job) {
            $job = null;
        }

        $form->bind($data);

        if ($form->isValid()) {
            $entity->setUser($user);
            $entity->setJob($job);
            $em->persist($entity);
            $em->flush();

            $view = $this->view(array(
                'error' => 'success',
                'message' => 'Employee saved with success',
                'employee' => $entity
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
     * params: name,description,begin,end
     * @Rest\Put("/api/employee/{id}")
     * @Rest\View()
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Employee');

        $entity = $entityRepository->find($id);
        if (!$entity) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Employee not found !'
                ), 200);
            return $this->handleView($view);
        }
        $form = $this->createForm(new EmployeeType(), $entity);

        $data = array();

        $userId = intval($request->request->get('user'));
        $jobId = intval($request->request->get('job'));
        $data["lastname"] = $request->request->get('lastname');
        $data["firstname"] = $request->request->get('firstname');
        $data["email"] = $request->request->get('email');
        $data["phone"] = $request->request->get('phone');
        $data["salary"] = floatval( $request->request->get('salary') );
        
        $employee = $em->getRepository("PlanITBundle:Employee")->findByEmail($data["email"]);
        if ($employee)
        {
	        $view = $this->view(array(
                'error' => 'error',
                'message' => 'Employee already exists !'
                ), 200);
            return $this->handleView($view);
        }

        $user = $em->getRepository("PlanITBundle:User")->find($userId);
        if (!$user) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'User not found !'
                ), 200);
            return $this->handleView($view);
        }

        $job = $em->getRepository("PlanITBundle:Job")->find($jobId);
        if (!$job) {
            $job = null;
        }


        $form->bind($data);

        if ($form->isValid()) {
            $entity->setUser($user);
            $entity->setJob($job);
            $em->persist($entity);
            $em->flush();

            $view = $this->view(array(
                'error' => 'success',
                'message' => 'Employee saved with success',
                'employee' => $entity
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
     * @Rest\Delete("/api/employee/{id}")
     * @Rest\View()
     */
    public function deleteAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Employee');
        
        $entity = $entityRepository->find($id);

        if (is_null($entity))
        {
          $view = $this->view(array(
            'error' => 'error',
            'message' => 'Employee not found !',
            ), 200);
					return $this->handleView($view);
        }
        
        $em->remove($entity);
        $em->flush();

        $view = $this->view(array(
            'error' => 'success',
            'message' => 'Employee deleted with success',
            ), 200);
        return $this->handleView($view);
    }

}