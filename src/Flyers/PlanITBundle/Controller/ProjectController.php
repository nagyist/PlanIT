<?php

namespace Flyers\PlanITBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

use Flyers\PlanITBundle\Entity\User;
use Flyers\PlanITBundle\Entity\Project;
use Flyers\PlanITBundle\Form\ProjectType;

class ProjectController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/api/projects")
     */
    public function cgetAction()
    {
        $em = $this->container->get("doctrine")->getManager();
        
        $entities = $em->getRepository("PlanITBundle:Project")->findAll();

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'projects' => $entities
            ), 200);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/projects/{slug}")
     */
    public function getProjectsUserAction($slug)
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

        $entities = $em->getRepository("PlanITBundle:Project")->findAllByUser($user);

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'projects' => $entities
            ), 200);
        return $this->handleView($view);

    }

    /**
     * @Rest\Get("/api/project/{id}")
     */
    public function getAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();

        $entity = $em->getRepository("PlanITBundle:Project")->find($id);
        if (!$entity) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Project not found !'
                ), 200);
            return $this->handleView($view);
        }

        $begin = $entity->getBegin()->format('d/m/Y');
        $end = $entity->getEnd()->format('d/m/Y');

        $entity->setBegin($begin);
        $entity->setEnd($end);

        $view = $this->view(array(
            'error' => 'success',
            'message' => '',
            'project' => $entity
            ), 200);
        return $this->handleView($view);

    }

    /**
     * params: name,description,begin,end,user
     * @Rest\Post("/api/project")
     */
    public function cpostAction(Request $request)
    {
        $em = $this->container->get("doctrine")->getManager();
        $userRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:User');

        $entity = new Project();
        $form = $this->createForm(new ProjectType(), $entity);
        
        $data = array();

        $userId = intval($request->request->get('user'));
        $data["name"] = $request->request->get('name');
        $data["description"] = $request->request->get('description');
        $data["begin"]   = null;
        $data["end"]     = null;

        $begin  = \DateTime::createFromFormat('d/m/Y', $request->request->get('begin'));
        $end    = \DateTime::createFromFormat('d/m/Y', $request->request->get('end'));

        $begin  = ($begin) ? $begin->format('d/m/Y') : null;
        $end    = ($end) ? $end->format('d/m/Y') : null;

        if ( !is_null($begin) ) $data['begin'] = $begin;
        else
        {
	        $view = $this->view(array(
                'error' => 'error',
                'message' => 'Begin null or malformed (format : d/m/Y) !'
                ), 200);
          return $this->handleView($view);
        }
        if ( !is_null($end) ) $data['end'] = $end;
        else
        {
	        $view = $this->view(array(
                'error' => 'error',
                'message' => 'End null or malformed (format : d/m/Y) !'
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

        $form->bind($data);

        if ($form->isValid()) {
            $entity->addUser($user);
            $em->persist($entity);
            $em->flush();

            $view = $this->view(array(
                'error' => 'success',
                'message' => 'Project saved with success',
                'project' => $entity
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
     * @Rest\Put("/api/project/{id}")
     * @Rest\View()
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Project');

        $entity = $entityRepository->find($id);
        if (!$entity) {
            $view = $this->view(array(
                'error' => 'error',
                'message' => 'Project not found !'
                ), 200);
            return $this->handleView($view);
        }
        $form = $this->createForm(new ProjectType(), $entity);

        $data = array();

        $data["name"] = $request->request->get('name');
        $data["description"] = $request->request->get('description');
        $data["begin"]   = null;
        $data["end"]     = null;

        $begin  = \DateTime::createFromFormat('d/m/Y', $request->request->get('begin'));
        $end    = \DateTime::createFromFormat('d/m/Y', $request->request->get('end'));

        $begin  = ($begin) ? $begin->format('d/m/Y') : null;
        $end    = ($end) ? $end->format('d/m/Y') : null;

        if ( !is_null($begin) ) $data['begin'] = $begin;
        else
        {
	        $view = $this->view(array(
                'error' => 'error',
                'message' => 'Begin null or malformed (format : d/m/Y) !'
                ), 200);
          return $this->handleView($view);
        }
        if ( !is_null($end) ) $data['end'] = $end;
        else
        {
	        $view = $this->view(array(
                'error' => 'error',
                'message' => 'End null or malformed (format : d/m/Y) !'
                ), 200);
          return $this->handleView($view);
        }

        $form->bind($data);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $view = $this->view(array(
                'error' => 'success',
                'message' => 'Project saved with success',
                'project' => $entity
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
     * @Rest\Delete("/api/project/{id}")
     * @Rest\View()
     */
    public function deleteAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Project');
        
        $entity = $entityRepository->find($id);

        if (is_null($entity))
        {
	        $view = $this->view(array(
            'error' => 'error',
            'message' => 'Project not found !',
            ), 200);
					return $this->handleView($view);
        }
        
        $em->remove($entity);
        $em->flush();

        $view = $this->view(array(
            'error' => 'success',
            'message' => 'Project deleted with success',
            ), 200);
        return $this->handleView($view);
    }

}