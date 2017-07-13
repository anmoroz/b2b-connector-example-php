<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class ProductIdentifiers
 * @package Connector\Gateway\Entity
 */
class ProductIdentifiers
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
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Product
     */
    private $product;


    /**
     * Set name
     *
     * @param string $name
     * @return ProductIdentifiers
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get identifier name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set identifier value
     *
     * @param mixed $value
     * @return ProductIdentifiers
     */
    public function setValue($value)
    {
        if (is_scalar($value)) {
            $this->value = (string) $value;
        } else {
            $this->value = serialize($value);
        }

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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return ProductIdentifiers
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
     * @return ProductIdentifiers
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
}
