<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 7/7/15
 * Time: 11:46 AM
 */

namespace Advertproject\PlatformBundle\DataFixtures\ORM;


use Advertproject\PlatformBundle\Entity\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProduct implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $list = array(
            array('xpéria', 2, 'brand new'),
            array('samsung', 7.45, 'available now'),
            array('sony', 5, 'refurbished')
        );

        for($i = 0; $i<count($list); $i++)
        {
            $product = new Product();

            $product->setPrice($list[$i][1]);
            $product->setDate(new \DateTime());
            $product->setDescription($list[$i][2]);
            $product->setTitle($list[$i][0]);

            $manager->persist($product);
        }

        $manager->flush();
    }
} 