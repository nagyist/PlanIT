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
use Flyers\PlanITBundle\Form\ProjectType;
use Flyers\PlanITBundle\Form\EmployeeType;
use Flyers\PlanITBundle\Form\ParticipantType;

class TaskController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/api/tasks")
     */
    public function cgetAction()
    {
        $em = $this->container->get("doctrine")->getManager();
        
        $entities = $em->getRepository("PlanITBundle:Task")->findAll();

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'tasks' => $entities
            ), 200);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/tasks/{slug}")
     */
    public function getTasksProjectAction($slug)
    {
        $em = $this->container->get("doctrine")->getManager();

        $id = intval($slug);

        if ($id <= 0)
        {
            $view = $this->view(array(
                    'error' => 'error',
                    'message' => 'Invalid Project'
                ), 200);
            return $this->handleView($view);
        }

        $project = $em->getRepository("PlanITBundle:Project")->find($slug);
        if (!$project)
        {
            $view = $this->view(array(
                    'error' => 'error',
                    'message' => 'No Project Found !'
                ), 200);
            return $this->handleView($view);
        }

        $entities = $em->getRepository("PlanITBundle:Task")->findAllByProject($project);

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'projects' => $entities
            ), 200);
        return $this->handleView($view);

    }

    /**
     * @Rest\Get("/api/task/{id}")
     */
    public function getAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();

        $entity = $em->getRepository("PlanITBundle:Task")->find($id);
        if (!$entity) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Task not found !'
                ), 200);
            return $this->handleView($view);
        }

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'project' => $entity
            ), 200);
        return $this->handleView($view);

    }

    /**
     * params: name,description,begin,end,user
     * @Rest\Post("/api/task")
     */
    public function cpostAction(Request $request)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Task');

    }

    /**
     * params: name,description,begin,end
     * @Rest\Put("/api/task/{id}")
     * @Rest\View()
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Task');

    }

    /**
     * @Rest\Delete("/api/task/{id}")
     * @Rest\View()
     */
    public function deleteAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Task');
        
        $entity = $entityRepository->find($id);

        if (!is_null($entity))
        {
            $em->remove($entity);
            $em->flush();
        }

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }


}