<?php

namespace Flyers\PlanITBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}", name="home")
     */
    public function indexAction($name)
    {
        return $this->render(
            "PlanITBundle:Default:index:html:twig"
        );
    }

    /**
     * @Route("/token/create/{username}/{password}", name="createToken")
     * @Template()
     */
    public function tokenAction($username, $password)
    {
    	$userManager = $this->container->get('fos_user.user_manager');

        $nonce = md5(rand());
        
        $user = $userManager->loadUserByUsername($username);

        $password = $user->getPassword();

        $created = date("c");

        $b64nonce = base64_encode($nonce);

        $digest = base64_encode(sha1($b64nonce.$created.$password, true));

        $token = 'UsernameToken Username="'.$username.'", PasswordDigest="'.$digest.'", Nonce="'.$b64nonce.'", Created="'.$created.'"';

        return $this->render(
            "PlanITBundle:Default:token.htm.twig",
            array('token' => $token)
        );
    }
}
