<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Price
 * @package Connector\Gateway\Entity
 */
class Price extends B2bGatewayEntity
{
    /**
     * @var float
     */
    private $price;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var PriceType
     */
    private $type;


    /**
     * Set price
     *
     * @param float|string $price
     * @return Price
     */
    public function setPrice($price)
    {
        $this->price = (float) $price;
        if ($this->price < 0) {
            $this->price = 0;
        }

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Price
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set product
     *
     * @param Product $product
     * @return Price
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set type
     *
     * @param PriceType $type
     * @return Price
     */
    public function setType(PriceType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return PriceType
     */
    public function getType()
    {
        return $this->type;
    }
}
