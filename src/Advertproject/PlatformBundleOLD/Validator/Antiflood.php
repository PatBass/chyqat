<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/24/15
 * Time: 1:33 PM
 */

namespace Advertproject\PlatformBundle\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * Class Antiflood
 * @package Advertproject\PlatformBundle\Validator
 * @Annotation
 */
class Antiflood extends Constraint
{
    public $message="Please wait 15 minutes before submitting another form";

    public function validatedBy()
    {
        return 'ap_platform_antiflood';
    }
} 