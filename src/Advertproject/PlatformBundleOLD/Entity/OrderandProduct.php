<?php

namespace Advertproject\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderandProduct
 *
 * @ORM\Table(name="order_and_product")
 * @ORM\Entity(repositoryClass="Advertproject\PlatformBundle\Entity\OrderandProductRepository")
 */
class OrderandProduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Advertproject\PlatformBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productsList;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Advertproject\PlatformBundle\Entity\ProductsOrder")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productsorder;

    public function __construt()
    {
        $this->productsList = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return OrderandProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }



    /**
     * Get product
     *
     * @return \stdClass 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set productsorder
     *
     * @param \stdClass $productsorder
     * @return OrderandProduct
     */
    public function setProductsorder($productsorder)
    {
        $this->productsorder = $productsorder;

        return $this;
    }

    /**
     * Get productsorder
     *
     * @return \stdClass 
     */
    public function getProductsorder()
    {
        return $this->productsorder;
    }

    public function addProduct(Product $product)
    {
        $this->productsList[] = $product;

        return $this;
    }

    public function removeProduct(Product $product)
    {
        $this->productsList->removeElement($product);
    }

    /**
     * Get productsList
     *
     * @return array
     */
    public function getProductsList()
    {
        return $this->productsList;
    }

    public function getTotalAmount()
    {
        $totalAmount = 0;
        foreach($this->getProductsList() as $product)
        {
            $totalAmount += $product->getPrice();
        }

        return $totalAmount;
    }
}
