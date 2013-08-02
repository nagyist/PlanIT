<?php

namespace Flyers\PlanITBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

class AlbumController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/albums")
     * @Rest\View()
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository("PlanITBundle:Album")->findAll();
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Rest\Get("/album/{id}")
     * @Rest\View()
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository("PlanITBundle:Album")->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find album entity');
        }

        return array(
            'entity' => $entity,
        );
    }

}