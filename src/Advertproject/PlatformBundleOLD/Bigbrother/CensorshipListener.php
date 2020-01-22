<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 7/1/15
 * Time: 6:18 PM
 */

namespace Advertproject\PlatformBundle\Bigbrother;


class CensorshipListener
{
    protected $processor;
    protected $listUsers = array();

    public function __construct(CensorshipProcessor $processor, $listUsers)
    {
        $this->processor = $processor;
        $this->listUsers = $listUsers;
    }

    public function processMessage(MessagePostEvent $event)
    {
        if(in_array($event->getUser()->getId(), $this->listUsers)){
            $this->processor->notifyEmail($event->getUser(), $event->getMessage());
            $message = $this->processor->censorMessage($event->getMessage());

            $event->setMessage($message);
        }
    }
} 