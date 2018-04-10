<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * Author: Andrey Morozov
 */

namespace Connector\Exceptions;

/**
 * Class ConnectorException
 * @package Connector\Exceptions
 */
class ConnectorException extends \Exception
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        echo sprintf(
            'Throw exception: "$s" on %s'.PHP_EOL,
            $message,
            date("Y.m.d H:i:s")
        );

        parent::__construct($message, $code, $previous);
    }
}