<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 7/1/15
 * Time: 5:06 PM
 */

namespace Advertproject\PlatformBundle\Bigbrother;


use Symfony\Component\Security\Core\User\UserInterface;

class CensorshipProcessor
{
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notifyEmail($message, UserInterface $user)
    {
        $msg =  \Swift_Message::newInstance()
            ->setSubject('Nouveau message d\'un utilisateur surveillé')
            ->setFrom('admin@domain.com')
            ->setTo('admin@domain.com')
            ->setBody("L'utilisateur surveillé".$user->getUsername()." a posté ce message :".$message)
        ;

        $this->mailer->send($msg);
    }

    public function censorMessage($message)
    {
        $message = str_replace(array('top secret', 'mot interdit'),'', $message);

        return $message;
    }
} 