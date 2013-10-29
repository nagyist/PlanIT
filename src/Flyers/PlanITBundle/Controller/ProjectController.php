<?php

namespace Flyers\PlanITBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

use Flyers\PlanITBundle\Entity\Project;
use Flyers\PlanITBundle\Form\ProjectType;

class ProjectController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/api/projects")
     * @Rest\View()
     */
    public function cgetAction()
    {
        $em = $this->container->get("doctrine")->getManager();
        
        $entities = $em->getRepository("PlanITBundle:Project")->findAll();
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Rest\Get("/api/project/{id}")
     * @Rest\View()
     */
    public function getAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();

        $entity = $em->getRepository("PlanITBundle:Project")->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find project entity');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * params: project[name],project[description],project[begin],project[end],project[users]
     * @Rest\Post("/api/project")
     * @Rest\View()
     */
    public function cpostAction(Request $request)
    {
        $em = $this->container->get("doctrine")->getManager();
        $userRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:User');

        $entity = new Project();
        $form = $this->createForm(new ProjectType(), $entity);

        $values = $request->request->get('project');
        $usersId = $values['users'];

        if ( is_array($usersId) ) {
            foreach ($usersId as $id) {
                $user = $userRepository->find($id);
                if (!is_null($user))
                    $entity->addUser($user);
            }
        } else {
            $user = $userRepository->find($usersId);
            if (!is_null($user))
                $entity->addUser($user);
        }
        
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirectView(
                $this->generateUrl(
                    'get_project',
                    array('id' => $entity->getId())
                ),
                Codes::HTTP_CREATED
            );
        } else {
            var_dump($form->getErrorsAsString());
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * params: project[name],project[description],project[begin],project[end],project[users]
     * @Rest\Put("/api/project/{id}")
     * @Rest\View()
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->container->get("doctrine")->getManager();
        $entityRepository = $this->container->get("doctrine")->getRepository('PlanITBundle:Project');

        $entity = $entityRepository->find($id);

        $form = $this->createForm(new ProjectType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->view(null, Codes::HTTP_NO_CONTENT);
        }

        return array(
            'form' => $form,
        );
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

        if (!is_null($entity))
        {
            $em->remove($entity);
            $em->flush();
        }

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }

}