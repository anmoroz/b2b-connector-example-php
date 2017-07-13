<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Commands;

use Connector\Gateway\Repository\OrderRepository;

use Connector\Helper\Lock;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class OrderCommand
 * @package Connector\Commands
 */
class OrderCommand extends Command
{
    protected function configure()
    {
        $this->setName("connector:order")
            ->setDescription('Отправка заказов в систему учета компании')
            ->setHelp(<<<EOT
Отправка заказов из шлюзовых таблиц B2B motion в систему учета компании

Применение:

<info>php console.php connector:order</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Doctrine\DBAL\Connection $gatewayConnection */
        $gatewayConnection = $this->getHelper('db')->getConnection();

        $lock = new Lock($gatewayConnection, __CLASS__);
        if (false === $lock->isFreeLock()) {
            $output->write('Running another order synchronization process', true);

            return;
        }
        $lock->setLock();

        $output->write('Start order synchronization on '.date("Y.m.d H:i:s"), true);

        $gatewayOrderRepository = new OrderRepository($gatewayConnection);
        $gatewayOrderRepository->onlyNew();

        $affectedRows = 0;
        $countRows = 0;

        // $yourCompanyOrderMapper - пример маппера, записывающего данные по заказу
        // в БД вашей компании или отправка, используя REST API
        /*foreach ($gatewayOrderRepository->iterate() as $order) {
            $countRows++;

            $result = $yourCompanyOrderMapper->save($order);
            if ($result) {
                $affectedRows++;
            }
        }*/

        $lock->unLock();

        /*$output->write(sprintf(
            'Done order synchronization on %s. Count - %d, affected - %d',
            date("Y.m.d H:i:s"),
            $countRows,
            $affectedRows
        ), true);*/
    }
}