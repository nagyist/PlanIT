<?php

namespace Flyers\PlanITBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/users")
     * @Rest\View()
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository("PlanITBundle:User")->findAll();
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Rest\Get("/user/{id}")
     * @Rest\View()
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository("PlanITBundle:User")->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find album entity');
        }

        return array(
            'entity' => $entity,
        );
    }

}