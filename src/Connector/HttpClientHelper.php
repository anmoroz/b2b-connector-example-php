<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * Author: Andrey Morozov
 */

namespace Connector;

use Symfony\Component\Console\Helper\Helper;

class HttpClientHelper extends Helper
{
    /**
     * @var RaecHttpClient
     */
    protected $_client;

    /**
     * HttpClientHelper constructor.
     * 
     * @param RaecHttpClient $client
     */
    public function __construct(RaecHttpClient $client)
    {
        $this->_client = $client;
    }

    /**
     * Retrieves the RaecHttpClient.
     *
     * @return RaecHttpClient
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'client';
    }
}