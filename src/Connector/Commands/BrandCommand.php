<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Connector\Gateway\Mappers\BrandMapper;

/**
 * Class BrandCommand
 * @package Connector\Commands
 */
class BrandCommand extends Command
{
    protected function configure()
    {
        $this->setName("connector:brand")
            ->setDescription('Обновление списка брендов')
            ->setHelp(<<<EOT
Запись данных по брендам в шлюзовые таблицы B2B motion + синхронизация синонимов брендов с базой РАЭК

Применение:

<info>php console.php connector:brand</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Start brand synchronization on '.date("Y.m.d H:i:s"), true);

        $affectedRows = 0;
        $countRows = 0;

        /** @var \Doctrine\DBAL\Connection $gatewayConnection */
        $gatewayConnection = $this->getHelper('db')->getConnection();
        $brandMapper = new BrandMapper($gatewayConnection);

        // $yourCompanyBrandRepository - пример репозитория, содержащего бренды товаров для вашей компании
        // Это может быть любая БД или REST API
        /*foreach ($yourCompanyBrandRepository->iterate() as $brand) {
            $countRows++;

            $result = $brandMapper->save($brand);
            if ($result) {
                $affectedRows++;
            }
        }

        $output->write(sprintf(
            'Done brand synchronization on %s. Count - %d, affected - %d',
            date("Y.m.d H:i:s"),
            $countRows,
            $affectedRows
        ), true);*/
    }
}