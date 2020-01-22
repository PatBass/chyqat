<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 16/05/18
 * Time: 19:08
 */

namespace Advertproject\PlatformBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class RedirectionListener
{
    public function __construct(ContainerInterface $container, Session $session)
    {
        $this->session = $session;
        $this->router = $container->get('router');
        $this->securityContext = $container->get('security.context');
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');

        if ($route == 'tokevote') {
            if (!$this->session->has('votant')) {
                $this->session->getFlashBag()->add('notice', 'Vous devez vous identifier pour pouvoir continuer');
                $event->setResponse(new RedirectResponse($this->router->generate('nakevote')));
            }
        }

        if ($route == 'deconnexion') {
            if ($this->session->has('votant')) {
                $event->setResponse(new RedirectResponse($this->router->generate('nakevote')));
            }
        }
    }

}