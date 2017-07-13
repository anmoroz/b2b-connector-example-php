<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class OrderItem
 * @package Connector\Gateway\Entity
 */
class OrderItem extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var string
     */
    private $article;

    /**
     * @var float
     */
    private $price;

    /**
     * @var PriceType
     */
    private $priceType;

    /**
     * @var float
     */
    private $quantity;


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
     * Set id
     *
     * @param int $id
     * @return OrderItem
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set order
     *
     * @param Order $order
     * @return OrderItem
     */
    public function setOrder(Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product article
     *
     * @param string $article
     * @return OrderItem
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get product article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set price
     *
     * @param float|string $price
     * @return OrderItem
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
     * Set quantity
     *
     * @param float|string $quantity
     * @return OrderItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (float) $quantity;
        if ($this->quantity < 0) {
            $this->quantity = 0;
        }

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price type
     *
     * @param PriceType $priceType
     * @return OrderItem
     */
    public function setPriceType(PriceType $priceType)
    {
        $this->priceType = $priceType;

        return $this;
    }

    /**
     * Get price type id
     *
     * @return PriceType
     */
    public function getPriceType()
    {
        return $this->priceType;
    }
}
