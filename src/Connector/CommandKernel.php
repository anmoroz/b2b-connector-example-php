<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Helper\HelperSet;

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Connection as DoctrineConnection;
use Doctrine\DBAL\Driver\PDOMySql\Driver as DoctrineMysqlDriver;

/**
 * Class CommandKernel
 * @package Connector
 */
class CommandKernel extends SymfonyApplication
{
    /**
     * List of commands to register
     *
     * @var array
     */
    protected $_commands = [
        \Connector\Commands\ProductCommand::class,
        \Connector\Commands\BrandCommand::class,
        \Connector\Commands\CatalogSectionCommand::class,
    ];

    /**
     * Instantiate the class
     *
     * @param string $appName
     * @param string $appVersion
     */
    public function __construct($appName, $appVersion)
    {
        parent::__construct($appName, $appVersion);

        $this->addHelpers();

        foreach($this->_commands as $command) {
            $this->add(new $command);
        }
    }

    /**
     * Set a helper instance
     */
    protected function addHelpers()
    {
        $configure = new Configure();

        // Gateway DBAL for MySQL
        $gatewayConnection = new DoctrineConnection(
            $configure->getGatewayDbalPrams(),
            new DoctrineMysqlDriver()
        );

        // Http client
        $raecHttpClient = new RaecHttpClient($configure->getRaecClientPrams());


        $helperSet = new HelperSet(
            [
                'db' => new ConnectionHelper($gatewayConnection),
                'reacClient' => new HttpClientHelper($raecHttpClient),
            ]
        );

        $this->setHelperSet($helperSet);
    }

    /**
     * Run the command
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->setCatchExceptions(true);
        $this->run();
    }
}