<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/24/15
 * Time: 1:48 PM
 */

namespace Advertproject\PlatformBundle\Validator;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

class AntifloodValidator extends ConstraintValidator
{
    private $requestStack;
    private $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em           = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $ip      = $request->getClientIp();

        $isFlood = $this->em
            ->getRepository('APPlatformBundle:Application')
            ->isFlood($ip, 15)
        ;

        if($isFlood){
            $this->context->addViolation($constraint->message);
        }
    }
} 