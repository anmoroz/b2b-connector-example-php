<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Gallery
 * @package Connector\Gateway\Entity
 */
class Gallery extends B2bGatewayEntity
{
    /**
     * @var \Connector\Gateway\Entity\Product
     */
    private $product;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * Set product
     *
     * @param Product $product
     * @return Gallery
     */
    public function setProduct(Product $product)
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
     * Set image url string
     *
     * @param string $imageUrl
     * @return Gallery
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get image url string
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
}