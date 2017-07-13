<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class DocumentItem
 * @package Connector\Gateway\Entity
 */
class DocumentItem extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Document
     */
    private $document;

    /**
     * @var integer
     */
    private $productId;

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
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $unitName;


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
     * Set document
     *
     * @param Document $document
     * @return DocumentItem|null
     */
    public function setDocument(Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set product id
     *
     * @param integer $productId
     * @return DocumentItem
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get product id
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set price
     *
     * @param float|string $price
     * @return DocumentItem
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
     * @return DocumentItem
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
     * Set amount
     *
     * @param float|string $amount
     * @return DocumentItem
     */
    public function setAmount($amount)
    {
        $this->amount = (float) $amount;
        if ($this->amount < 0) {
            $this->amount = 0;
        }

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set price type
     *
     * @param PriceType $priceType
     * @return DocumentItem
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


    /**
     * Set unit name
     *
     * @param string $unitName
     * @return DocumentItem
     */
    public function setUnitName($unitName)
    {
        $this->unitName = $unitName;

        return $this;
    }

    /**
     * Get unit name
     *
     * @return string
     */
    public function getUnitName()
    {
        return $this->unitName;
    }
}