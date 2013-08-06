<?php

namespace Flyers\PlanITBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

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

}