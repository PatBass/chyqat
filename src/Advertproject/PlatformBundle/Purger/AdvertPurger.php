<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 7/9/15
 * Time: 11:09 PM
 */

namespace Advertproject\PlatformBundle\Purger;



use Doctrine\ORM\EntityManagerInterface;

class AdvertPurger
{
    private $mailer;
    private $em;

    public function __construct(\Swift_Mailer $mailer, EntityManagerInterface $em)
    {
        $this->mailer = $mailer;
        $this->em     = $em;
    }

    public function advertPurger( \Datetime $days)
    {
        $date = new \Datetime($days.' days ago');

        $listAdverts = $this->em
            -> getRepository("APPlatformBundle:Advert")
            -> getAdvertsWithNoApplicationAndBefore($date)
        ;

        foreach($listAdverts as $advert)
        {
            $this->em-> remove($advert);
        }

        $this->em->flush();
    }
} 