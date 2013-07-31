<?php

use FOS\RestBundle\Controller\FOSRestController;

class AlbumController extends FOSRestController
{
    /**
     * @Get("/albums, defaults={"_format" = "json"}")
     * 
     */
    public function getAlbumsAction()
    {
        $albums = $this->getDoctrine()->getRepository("PlanITBundle:Albums")->findAll();
        $data = $albums; // get data, in this case list of users.
        $view = $this->view($data, 200)
            ->setTemplate("PlanITBundle:Albums:getAlbums.html.twig")
            ->setTemplateVar('albums')
        ;

        return $this->handleView($view);
    }

    public function redirectAction()
    {
        $view = $this->redirectView($this->generateUrl('home'), 301);
        // or
        // $view = $this->routeRedirectView('some_route', array(), 301);

        return $this->handleView($view);
    }
}