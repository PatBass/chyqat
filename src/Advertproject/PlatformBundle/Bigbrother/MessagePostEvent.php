<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/30/15
 * Time: 2:19 PM
 */

namespace Advertproject\PlatformBundle\Bigbrother;


//use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class MessagePostEvent extends Event
{
    protected $message;
    protected $user;

    public function __construct($message, UserInterface $user)
    {
        $this->message = $message;
        $this->user    = $user;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
} 