<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Order
 * @package Connector\Gateway\Entity
 */
class Order extends B2bGatewayEntity
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
     * @var Company
     */
    private $company;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $items;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Order
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
     * @return Order
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
     * Get order status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set order status
     *
     * @param int $status
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = (int) $status;

        return $this;
    }

    /**
     * Get order comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set order comment
     *
     * @param string $comment
     * @return Order
     */
    public function setComment($comment)
    {
        $this->comment = mb_substr((string) $comment, 0, 255);

        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Order
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
     * @param Company $company
     * @return Order
     */
    public function setCompany(Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Add product items
     *
     * @param OrderItem $orderItem
     *
     * @return Order
     */
    public function addItem(OrderItem $orderItem)
    {
        $this->items[] = $orderItem;

        return $this;
    }

    /**
     * Remove product items
     *
     * @param OrderItem $orderItem
     */
    public function removeItem(OrderItem $orderItem)
    {
        $this->items->removeElement($orderItem);
    }

    /**
     * Get product items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}