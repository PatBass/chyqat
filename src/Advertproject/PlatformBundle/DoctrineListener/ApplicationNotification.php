<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/18/15
 * Time: 1:51 PM
 */

namespace Advertproject\PlatformBundle\DoctrineListener;


use Advertproject\PlatformBundle\Entity\Application;
use Advertproject\PlatformBundle\Entity\Contact;
use Advertproject\UserBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ApplicationNotification
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $arg)
    {
        $entity = $arg->getEntity();

        if ($entity instanceof User) {
            $message = new \Swift_Message(
                'New Subscription',
                'A company has just completed a subscription'
            );

            $message
                //->addTo($entity->getAdvert()->getAuthor())
                ->addTo('patrickbassoukissa@gmail.com')
                -> addFrom('Andema@yafabhi.com')
            ;

            $this->mailer->send($message);

        } elseif ($entity instanceof Contact) {
            $message = new \Swift_Message(
                'Message from Contact Page',
                'Somebody has just posted a messa*ge.'
            );

            $message
                //->addTo($entity->getAdvert()->getAuthor())
                ->addTo('patrickbassoukissa@gmail.com')
                -> addFrom('Andema@yafabhi.com')
            ;
            $this->mailer->send($message);

        } else {
            return;
        }


    }
} 