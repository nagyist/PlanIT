<?php

namespace Flyers\PlanITBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\Rest\Util\Codes;

use Flyers\PlanITBundle\Entity\User;
use Flyers\PlanITBundle\Form\UserType;

class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/api/users")
     * @Rest\View()
     */
    public function cgetAction()
    {
        $em = $this->container->get("doctrine")->getManager();
        
        $entities = $em->getRepository("PlanITBundle:User")->findAll();
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Rest\Get("/api/user/{id}")
     * @Rest\View()
     */
    public function getAction($id)
    {
        $em = $this->container->get("doctrine")->getManager();

        $entity = $em->getRepository("PlanITBundle:User")->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find album entity');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * @Rest\Post("/user/auth")
     * @Rest\View()
     */
    public function authAction(Request $request)
    {
        $um = $this->get('fos_user.user_manager');
        $providerKey = $this->container->getParameter('fos_user.firewall_name');

        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $user = $um->findUserByUsername($email);
        if (!$user)
        {
            throw $this->createNotFoundException('No user found!');
        }

        $token = new UsernamePasswordToken($user, $user->getPassword(), $providerKey, $user->getRoles());

        $context = $this->get('security.context');
        $context->setToken($token);

        return array(
            'token' => $context->getToken(),
        );

    }

}