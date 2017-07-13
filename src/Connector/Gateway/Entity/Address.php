<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Address
 * @package Connector\Gateway\Entity
 */
class Address extends B2bGatewayEntity
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $addressHash;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Connector\Gateway\Entity\Company
     */
    private $company;


    /**
     * Set address
     *
     * @param string $address
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = trim($this->removeSpaces($address), "., \t\n\r\0\x0B");
        $this->addressHash = md5($this->address);

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get address hash
     *
     * @return string
     */
    public function getAddressHash()
    {
        return $this->addressHash;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Address
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
     * Set company
     *
     * @param \Connector\Gateway\Entity\Company $company
     * @return Address
     */
    public function setCompany(\Connector\Gateway\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Connector\Gateway\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
