<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 9/30/15
 * Time: 4:01 PM
 */

namespace Advertproject\UserBundle\DataFixtures\ORM;


use Advertproject\UserBundle\Entity\Type;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadType implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Manufacturer',
            'Buyer',
            'Agent'
        );

        foreach($names as $name)
        {
            $type = new Type();
            $type->setName($name);

            $manager->persist($type);
        }

        $manager->flush();
    }
} 