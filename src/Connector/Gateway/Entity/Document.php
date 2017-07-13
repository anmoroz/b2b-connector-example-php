<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Document
 * @package Connector\Gateway\Entity
 */
class Document extends B2bGatewayEntity
{
    const INVOICE_TYPE_ID = 1; // Счет
    const WAYBILL_TYPE_ID = 2; // Накладная
    const INVOICEF_TYPE_ID = 3; // Счет-фактура

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $externalId;

    /**
     * @var DocumentType
     */
    private $type;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var Document
     */
    private $parentDocument;

    /**
     * @var string
     */
    private $number;

    /**
     * @var float
     */
    private $totalAmount;

    /**
     * @var /DateTime
     */
    private $docDate;

    /**
     * @var boolean
     */
    private $incoming;

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
     * @return Document
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
     * @return Document
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
     * Set document type
     *
     * @param DocumentType $type
     * @return Document
     */
    public function setType(DocumentType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get document type
     *
     * @return DocumentType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set order
     *
     * @param Order $order
     * @return Document
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set parent document
     *
     * @param Document $parentDocument
     * @return Document
     */
    public function setParentDocument(Document $parentDocument)
    {
        $this->parentDocument = $parentDocument;

        return $this;
    }

    /**
     * Get parent document
     *
     * @return Document
     */
    public function getParentDocument()
    {
        return $this->parentDocument;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Document
     */
    public function setNumber($number)
    {
        $this->number = $this->removeSpaces($number);

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set total amount
     *
     * @param float|string $totalAmount
     * @return Document
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = (float) $totalAmount;
        if ($this->totalAmount < 0) {
            $this->totalAmount = 0;
        }

        return $this;
    }

    /**
     * Get total amount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set document date
     *
     * @param \DateTime $docDate
     * @return Document
     */
    public function setDocDate(\DateTime $docDate)
    {
        $this->docDate = $docDate;

        return $this;
    }

    /**
     * Get document date
     *
     * @return \DateTime
     */
    public function getDocDate()
    {
        return $this->docDate;
    }

    /**
     * Set is incoming document
     *
     * @param boolean $incoming
     * @return Document
     */
    public function setIncoming($incoming)
    {
        $this->incoming = $incoming ? 1 : 0;

        return $this;
    }

    /**
     * Get is incoming document
     *
     * @return boolean
     */
    public function getIncoming()
    {
        return (boolean) $this->incoming;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Document
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
     * Add product items
     *
     * @param DocumentItem $documentItem
     *
     * @return Document
     */
    public function addItem(DocumentItem $documentItem)
    {
        $this->items[] = $documentItem;

        return $this;
    }

    /**
     * Remove product items
     *
     * @param DocumentItem $documentItem
     */
    public function removeItem(DocumentItem $documentItem)
    {
        $this->items->removeElement($documentItem);
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