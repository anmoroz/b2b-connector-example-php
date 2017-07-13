<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Feature
 * @package Connector\Gateway\Entity
 */
class Feature extends B2bGatewayEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Connector\Gateway\Entity\Product
     */
    private $product;


    /**
     * Set name
     *
     * @param string $name
     * @return Feature
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Feature
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return Feature
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return Feature
     */
    public function setSort($sort)
    {
        $this->sort = (int) $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Feature
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
     * @return Feature
     */
    public function setProduct(\Connector\Gateway\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Connector\Gateway\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
