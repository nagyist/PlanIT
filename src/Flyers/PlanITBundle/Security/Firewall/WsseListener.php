<?php

namespace Flyers\PlanITBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

use Flyers\PlanITBundle\Security\Authentication\Token\WsseUserToken;

class WsseListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, LoggerInterface $logger)
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->logger = $logger;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        // Check if authentication Token is present
        if ($request->headers->has('x-wsse')) {

            // Token parser
            $wsseRegex = '/UsernameToken Username="([^"]+)", PasswordDigest="([^"]+)", Nonce="([^"]+)", Created="([^"]+)"/';

            if (preg_match($wsseRegex, $request->headers->get('x-wsse'), $matches)) {
                $token = new WsseUserToken();
                $token->setUser($matches[1]);

                $token->digest   = $matches[2];
                $token->nonce    = $matches[3];
                $token->created  = $matches[4];

                try {
                    // Authentication process 
                    $authToken = $this->authenticationManager->authenticate($token);
                    $this->securityContext->setToken($authToken);
                    
                    return;
                } catch (AuthenticationException $failed) {
                    // ... you might log something here
                    $this->logger->error($failed->getMessage());

                    // To deny the authentication clear the token. This will redirect to the login page.
                    // $this->securityContext->setToken(null);
                    // return;

                    // Deny authentication with a '403 Forbidden' HTTP response
                    $response = new Response();
                    $response->setStatusCode(403);
                    $event->setResponse($response);
                }
            }
        }

        // By default deny authentication
        $response = new Response();
        $response->setStatusCode(403);
        $event->setResponse($response);
        
    }
}