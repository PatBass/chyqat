<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/29/15
 * Time: 8:59 PM
 */

namespace Advertproject\PlatformBundle\Beta;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
    protected $betaHTML;
    protected $endDate;

    public function __construct(BetaHTML $betaHTML, $endDate)
    {
        $this->betaHTML = $betaHTML;
        $this->endDate = new \Datetime($endDate);
    }

    public function processBeta(FilterResponseEvent $event)
    {
        if(!$event->isMasterRequest()){
            return;
        }

        $remainingDays = $this->endDate->diff(new \Datetime())->format('%d');

        if($remainingDays <= 0){
            return;
        }

        $response = $this->betaHTML->addBeta($event->getResponse(), $remainingDays);

        $event->setResponse($response);
    }
} 