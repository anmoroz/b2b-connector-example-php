<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector;

use Symfony\Component\Yaml\Parser;

/**
 * Class Configurator
 * @package Connector
 */
class Configure
{
    const CONFIG_FILE = 'config.yml';

    private $configData;

    public function __construct()
    {
        $yaml = new Parser();
        $this->configData = $yaml->parse(
            file_get_contents(APP_DIR.'/config/'.self::CONFIG_FILE)
        );
    }

    /**
     * @return array
     */
    public function getGatewayDbalPrams()
    {
        return $this->configData['doctrine']['dbal']['gateway'];
    }

    /**
     * Other congig
     */
}