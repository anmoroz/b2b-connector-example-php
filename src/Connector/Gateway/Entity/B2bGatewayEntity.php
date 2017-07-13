<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class B2bGatewayEntity
 * @package Connector\Gateway\Entity
 */
abstract class B2bGatewayEntity
{
    /**
     * Sets the attribute values in a massive way.
     * @param array $values attribute values (name => value) to be assigned to the entity.
     */
    public function setAttributes($values)
    {
        if (is_array($values)) {
            foreach ($values as $name => $value) {
                $setter = 'set' . ucfirst($name);
                if (method_exists($this, $setter)) {
                    // set property
                    $this->$setter($value);
                }
            }
        }
    }

    /**
     * @param string $str
     * @return string
     */
    protected function removeSpaces($str)
    {
        return trim(preg_replace('/ +/', ' ', $str));
    }
}