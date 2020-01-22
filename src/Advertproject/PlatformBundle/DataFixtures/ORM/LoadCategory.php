<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/13/15
 * Time: 11:35 PM
 */

namespace Advertproject\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Advertproject\PlatformBundle\Entity\Category;

class LoadCategory implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Développement Web',
            'Développement mobile',
            'Graphisme',
            'Réseau'
        );

        foreach($names as $name)
        {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
        }

        $manager->flush();
    }
} 