<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class ContractPrice
 * @package Connector\Gateway\Entity
 */
class ContractPrice extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Company
     */
    private $company;

    /**
     * @var PriceType
     */
    private $priceType;

    /**
     * @var float
     */
    private $discount;

    /**
     * @var Brand
     */
    private $brand;

    /**
     * @var string
     */
    private $categoryIds;

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
     * @return ContractPrice
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set company
     *
     * @param Company $company
     * @return ContractPrice
     */
    public function setCompany(Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return Company|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set price type
     *
     * @param PriceType $priceType
     * @return ContractPrice
     */
    public function setPriceType(PriceType $priceType = null)
    {
        $this->priceType = $priceType;

        return $this;
    }

    /**
     * Get price type
     *
     * @return PriceType|null
     */
    public function getPriceType()
    {
        return $this->priceType;
    }

    /**
     * Set discount percent
     *
     * @param float $discount
     * @return ContractPrice
     */
    public function setDiscount($discount)
    {
        if ((float) $discount >= 0 && (float) $discount < 100) {
            $this->discount = (float) $discount;
        }

        return $this;
    }

    /**
     * Get discount
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set brand
     *
     * @param Brand $brand
     * @return ContractPrice
     */
    public function setBrand(Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Connector\Gateway\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set category ids
     *
     * @param string $categoryIds
     * @return ContractPrice
     */
    public function setCategoryIds($categoryIds)
    {
        $this->categoryIds = $categoryIds;

        return $this;
    }

    /**
     * Get category ids
     *
     * @return string
     */
    public function getCategoryIds()
    {
        return $this->categoryIds;
    }

    /**
     * Set updated at
     *
     * @param \DateTime $updatedAt
     * @return ContractPrice
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