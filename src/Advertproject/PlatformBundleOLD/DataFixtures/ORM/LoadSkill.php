<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 6/16/15
 * Time: 12:22 PM
 */

namespace Advertproject\PlatformBundle\DataFixtures\ORM;


use Advertproject\PlatformBundle\Entity\Skill;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSkill implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array('PHP', "Java", "Symfony2", "Photoshop", "Bloc-note", "C++", "Blender");

        foreach($names as $name)
        {
            $skill = new Skill();
            $skill->setName($name);

            $manager->persist($skill);
        }

        $manager->flush();
    }
} 