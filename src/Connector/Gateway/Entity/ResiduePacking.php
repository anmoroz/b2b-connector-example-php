<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class ResiduePacking
 * @package Connector\Gateway\Entity
 */
class ResiduePacking extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var Store
     */
    private $store;

    /**
     * @var string
     */
    private $consignment;

    /**
     * @var float
     */
    private $residue;

    /**
     * @var float
     */
    private $reserve = 0;

    /**
     * @var \DateTime
     */
    private $updatedAt;

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
     * @return ResiduePacking
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set product
     *
     * @param Product $product
     * @return ResiduePacking
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
     * @return ResiduePacking
     */
    public function setStore(Store $store = null)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return Store
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set consignment
     *
     * @param string $consignment
     * @return ResiduePacking
     */
    public function setConsignment($consignment)
    {
        $this->consignment = $consignment;

        return $this;
    }

    /**
     * Get consignment
     *
     * @return string
     */
    public function getConsignment()
    {
        return $this->consignment;
    }

    /**
     * Set residue
     *
     * @param string $residue
     * @return ResiduePacking
     */
    public function setResidue($residue)
    {
        if ((float) $residue >= 0) {
            $this->residue = (float) $residue;
        }

        return $this;
    }

    /**
     * Get residue
     *
     * @return string
     */
    public function getResidue()
    {
        return $this->residue;
    }

    /**
     * Set reserve
     *
     * @param string $reserve
     * @return ResiduePacking
     */
    public function setReserve($reserve)
    {
        if ((float) $reserve >= 0) {
            $this->reserve = (float) $reserve;
        }

        return $this;
    }

    /**
     * Get reserve
     *
     * @return string
     */
    public function getReserve()
    {
        return $this->reserve;
    }

    /**
     * Set updated at
     *
     * @param \DateTime $updatedAt
     * @return ResiduePacking
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updated at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
