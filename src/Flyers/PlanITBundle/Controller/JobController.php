<?php

namespace Flyers\PlanITBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

use Flyers\PlanITBundle\Entity\Job;
use Flyers\PlanITBundle\Entity\JobRepository;
use Flyers\PlanITBundle\Form\JobType;

class JobController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/api/jobs")
     */
    public function cgetAction()
    {
        $em = $this->container->get("doctrine")->getManager();
        
        $entities = $em->getRepository("PlanITBundle:Job")->findAll();

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'jobs' => $entities
            ), 200);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/job/{id}")
     * @Rest\View()
     */
    public function getAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();

        $entity = $em->getRepository("PlanITBundle:Job")->find($id);
        if (!$entity) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Job not found !'
                ), 200);
            return $this->handleView($view);
        }

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'job' => $entity
            ), 200);
        return $this->handleView($view);

    }

    /**
     * params: name,description
     * @Rest\Post("/api/job")
     * @Rest\View()
     */
    public function cpostAction(Request $request)
    {
        $em = $this->container->get("doctrine")->getManager();

        $entity = new Job();
        $form = $this->createForm(new JobType(), $entity);
        
        $job = array();

        $job["name"] = $request->request->get('name');
        $job["description"] = $request->request->get('description');
        
        $confirm = $em->getRepository('PlanITBundle:Job')->findByName($job["name"]);
    		if ($confirm)
    		{
      		$view = $this->view(array(
            'error' => 'error',
            'message' => 'Job already created',
            ), 200);
					return $this->handleView($view);
    		}
        
        $form->bind($job);

        if ($form->isValid()) {
        
        		
        
            $em->persist($entity);
            $em->flush();

            $view = $this->view(array(
                'error' => 'success',
                'message' => 'Job saved with success',
                'job' => $entity
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
     * @Rest\Put("/api/job/{id}")
     * @Rest\View()
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Job');

        $entity = $entityRepository->find($id);
        if (!$entity) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Job not found !'
                ), 200);
            return $this->handleView($view);
        }
        $form = $this->createForm(new JobType(), $entity);

        $job = array();

        $job["name"] = $request->request->get('name');
        $job["description"] = $request->request->get('description');
        
        $confirm = $em->getRepository('PlanITBundle:Job')->findByName($job["name"]);
    		if ($confirm)
    		{
      		$view = $this->view(array(
            'error' => 'error',
            'message' => 'Job already created',
            ), 200);
					return $this->handleView($view);
    		}
        
        $form->bind($job);

        if ($form->isValid()) {
        
            $em->persist($entity);
            $em->flush();

            $view = $this->view(array(
                'error' => 'success',
                'message' => 'Job saved with success',
                'job' => $entity
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
     * @Rest\Delete("/api/job/{id}")
     * @Rest\View()
     */
    public function deleteAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Job');
        
        $entity = $entityRepository->find($id);

        if (is_null($entity))
        {
          $view = $this->view(array(
            'error' => 'error',
            'message' => 'Job not found !',
          ), 200);
	        return $this->handleView($view);
        }
        
        $em->remove($entity);
        $em->flush();

        $view = $this->view(array(
            'error' => 'success',
            'message' => 'Job deleted with success',
            ), 200);
        return $this->handleView($view);
    }

}