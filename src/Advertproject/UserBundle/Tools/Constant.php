<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 10/20/15
 * Time: 4:14 PM
 */

namespace Advertproject\UserBundle\Tools;


class Constant
{
    const TYPE_MANUFACTURER = '0';
    const TYPE_BUYER        = '1';
    const TYPE_AGENT        = '2';

   static public function getTypeList()
   {
       return array(
           self::TYPE_MANUFACTURER => 'Manufacturer',
           self::TYPE_BUYER        => 'Buyer',
           self::TYPE_AGENT        => 'Agent'
       );
   }
} 