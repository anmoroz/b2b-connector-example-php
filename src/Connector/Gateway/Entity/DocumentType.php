<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class DocumentType
 * @package Connector\Gateway\Entity
 */
class DocumentType extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $nameShort;


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
     * @return DocumentType
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return DocumentType
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
     * Set name short
     *
     * @param string $nameShort
     * @return DocumentType
     */
    public function setNameShort($nameShort)
    {
        $this->nameShort = $this->removeSpaces($nameShort);

        return $this;
    }

    /**
     * Get name short
     *
     * @return string
     */
    public function getNameShort()
    {
        return $this->nameShort;
    }
}
