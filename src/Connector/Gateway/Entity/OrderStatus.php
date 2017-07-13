<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class OrderStatus
 * @package Connector\Gateway\Entity
 */
class OrderStatus extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $externalId;

    /**
     * @var string
     */
    private $name;

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
     * @return OrderStatus
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set external id
     *
     * @param string $externalId
     * @return OrderStatus
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Get external id
     *
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return OrderStatus
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return OrderStatus
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
}
