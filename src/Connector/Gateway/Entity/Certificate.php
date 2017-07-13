<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Certificate
 * @package Connector\Gateway\Entity
 */
class Certificate extends B2bGatewayEntity
{
    /**
     * @var \Connector\Gateway\Entity\Product
     */
    private $product;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \DateTime
     */
    private $validityFrom;

    /**
     * @var \DateTime
     */
    private $validityTo;

    /**
     * Set product
     *
     * @param \Connector\Gateway\Entity\Product $product
     * @return Certificate
     */
    public function setProduct(\Connector\Gateway\Entity\Product $product)
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

    /**
     * Set name
     *
     * @param string $name
     * @return Certificate
     */
    public function setName($name)
    {
        $this->name = $this->removeSpaces($name);

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
     * Set url
     *
     * @param string $url
     * @return Certificate
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set validity from
     *
     * @param \DateTime|string $validityFrom
     * @return Certificate
     */
    public function setValidityFrom($validityFrom)
    {
        if (is_string($validityFrom)) {
            $validityFromDateTime = \DateTime::createFromFormat('Y-m-d', $validityFrom);
            if ($validityFromDateTime && $validityFromDateTime->format('Y-m-d') === $validityFrom) {
                $validityFrom = $validityFromDateTime;
            } else {
                $validityFrom = null;
            }
        }
        $this->validityFrom = $validityFrom;

        return $this;
    }

    /**
     * Get validity from
     *
     * @return string|null
     */
    public function getValidityFrom()
    {
        return $this->validityFrom ? $this->validityFrom->format('Y-m-d') : null;
    }

    /**
     * Set validity to
     *
     * @param \DateTime|string $validityTo
     * @return Certificate
     */
    public function setValidityTo($validityTo)
    {
        if (is_string($validityTo)) {
            $validityToDateTime = \DateTime::createFromFormat('Y-m-d', $validityTo);
            if ($validityToDateTime && $validityToDateTime->format('Y-m-d') === $validityTo) {
                $validityTo = $validityToDateTime;
            } else {
                $validityTo = null;
            }
        }
        $this->validityTo = $validityTo;

        return $this;
    }

    /**
     * Get validity to
     *
     * @return string|null
     */
    public function getValidityTo()
    {
        return $this->validityTo ? $this->validityTo->format('Y-m-d') : null;
    }
}