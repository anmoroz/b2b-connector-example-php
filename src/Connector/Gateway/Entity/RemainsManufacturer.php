<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class RemainsManufacturer
 * @package Connector\Gateway\Entity
 */
class RemainsManufacturer extends B2bGatewayEntity
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var string
     */
    private $storageName;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var \DateTime
     */
    private $relevanceDate;

    /**
     * Set product
     *
     * @param Product $product
     * @return RemainsManufacturer
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
     * Set storage name
     *
     * @param string $storageName
     * @return RemainsManufacturer
     */
    public function setStorageName($storageName)
    {
        $this->storageName = $this->removeSpaces($storageName);

        return $this;
    }

    /**
     * Get storage name
     *
     * @return string
     */
    public function getStorageName()
    {
        return $this->storageName;
    }

    /**
     * Set quantity
     *
     * @param int $quantity
     * @return RemainsManufacturer
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
        if ($this->quantity < 0) {
            $this->quantity = 0;
        }

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
     * Set relevance date
     *
     * @param \DateTime|string $relevanceDate
     * @return RemainsManufacturer
     */
    public function setRelevanceDate($relevanceDate)
    {
        if (is_string($relevanceDate)) {
            $relevanceDateDateTime = \DateTime::createFromFormat('Y-m-d', $relevanceDate);
            if ($relevanceDateDateTime && $relevanceDateDateTime->format('Y-m-d') === $relevanceDate) {
                $relevanceDate = $relevanceDateDateTime;
            } else {
                $relevanceDate = null;
            }
        }
        $this->relevanceDate = $relevanceDate;

        return $this;
    }

    /**
     * Get relevance date
     *
     * @return string|null
     */
    public function getRelevanceDate()
    {
        return $this->relevanceDate ? $this->relevanceDate->format('Y-m-d') : null;
    }
}
