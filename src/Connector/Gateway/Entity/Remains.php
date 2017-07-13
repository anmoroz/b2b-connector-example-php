<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Remains
 * @package Connector\Gateway\Entity
 */
class Remains extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $totalItemCount;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var Store
     */
    private $store;


    /**
     * Set totalItemCount
     *
     * @param float $totalItemCount
     * @return Remains
     */
    public function setTotalItemCount($totalItemCount)
    {
        $this->totalItemCount = (float) $totalItemCount;
        if ($this->totalItemCount < 0) {
            $this->totalItemCount = 0;
        }

        return $this;
    }

    /**
     * Get totalItemCount
     *
     * @return integer 
     */
    public function getTotalItemCount()
    {
        return $this->totalItemCount;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Remains
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Remains
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
     * @return Remains
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
     * Set store
     *
     * @param Store $store
     * @return Remains
     */
    public function setStore(Store $store = null)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return \Connector\Gateway\Entity\Store
     */
    public function getStore()
    {
        return $this->store;
    }
}
