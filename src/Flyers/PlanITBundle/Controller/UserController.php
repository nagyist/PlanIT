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
     */
    public function authAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $um = $this->get('fos_user.user_manager');
        $es = $this->get('security.encoder_factory');
        $providerKey = $this->container->getParameter('fos_user.firewall_name');

        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $user = $um->findUserByUsername($email);
        if (!$user)
        {
            return array(
                'error' => 'error',
                'message' => 'No User Found !'
            );
        }
        
        if (!$user->isEnabled())
        {
            return array(
                'error' => 'error',
                'message' => 'Inactive user'
            );
        }
        
        $encoder = $es->getEncoder($user);
        $encoded_pass = $encoder->encodePassword($password, $user->getSalt());
        if ($user->getPassword() != $encoded_pass) {
            return array(
                'error' => 'error',
                'message' => 'Invalid password'
            );
        }

        $token = new UsernamePasswordToken($user, $user->getPassword(), $providerKey, $user->getRoles());

        $context = $this->get('security.context');
        $context->setToken($token);

        return array(
            'error' => 'success',
            'token' => $context->getToken(),
        );

    }

    /**
     * @Rest\Post("/user/create")
     */
    public function createAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        
        $um = $this->get('fos_user.user_manager');

        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $password_confirm = $request->request->get('password_confirm');

        $check = $um->findUserByUsername($email);
        if (!is_null($check))
        {
            return array(
                'error' => 'error',
                'message' => 'User already exist'
            );
        }

        if ($password != $password_confirm)
        {
            return array(
                'error' => 'error',
                'message' => 'Invalid confirmation password'
            );   
        }

        $user = $um->createUser();

        $user->setUsername($email);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(false);

        $um->updateUser($user, true);

        // TODO Send confirmation email

        return array(
            'error' => 'success',
            'user' => $serializer->serialize($user, 'json'),
            'message' => 'User created with success'
        );

    }

}