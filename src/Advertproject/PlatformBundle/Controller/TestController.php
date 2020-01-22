<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 7/6/15
 * Time: 1:55 PM
 */

namespace Advertproject\PlatformBundle\Controller;


use Advertproject\PlatformBundle\Entity\OrderandProduct;
use Advertproject\PlatformBundle\Entity\Product;
use Advertproject\PlatformBundle\Entity\ProductsOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();

         $productsList = $em
             -> getRepository("APPlatformBundle:Product")
             -> findAll()
         ;

        $productsOrder = new ProductsOrder();
        $productsOrder->setDate(new \DateTime());
        $productsOrder->setDeliveryAddress("Bourgogne, 20000 Casablanca - Morocco");

        foreach($productsList as $product)
        {

            $orderandProduct = new OrderandProduct();
            $orderandProduct->addProduct($product);
            $orderandProduct->setProductsorder($productsOrder);
            $orderandProduct->setQuantity(14);

            $em->persist($orderandProduct);
        }
        $em->flush();

        return $this->render("APPlatformBundle:Test:test.html.twig", array(
           'orderandProduct' => $orderandProduct,
            'productsList'   => $productsList
        ));
    }

    public function getTotalPrice(ProductsOrder $productsOrder)
    {
        $totalPrice = 0;

        foreach($productsOrder->getProductList() as $product)
        {
            $totalPrice += $product->getPrice();
        }

        return $totalPrice;
    }

    public function purgeAction($days, Request $request)
    {
        $purger = $this->get('ap_platform.advert_purger');
        $purger-> advertPurger($days);
        $request->getSession()->getFlashBag()->add('notice', 'Nettoyage effectué !');
        return $this->redirect($this->generateUrl('ap_platform_home'));
    }
} 