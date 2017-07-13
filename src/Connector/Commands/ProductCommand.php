<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use Connector\Gateway\Mappers\ProductMapper;

/**
 * Class ProductCommand
 * @package Connector\Commands
 */
class ProductCommand extends Command
{
    const DELETE_BATCH_SIZE = 1000;

    protected function configure()
    {
        $this->setName("connector:product")
            ->setDescription('Обновление товаров')
            ->setDefinition([
                new InputOption(
                    'lastchange-minutes',
                    'lcm',
                    InputOption::VALUE_OPTIONAL,
                    'Синхронизация товаров, измененных за последние m минут'
                )
            ])
            ->setHelp(<<<EOT
Запись данных по товарам в шлюзовые таблицы B2B motion

Применение:

<info>php console.php connector:product</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Start update products on '.date("Y.m.d H:i:s"), true);

        /*$yourProductRepository  = new YourCompanyProductRepository();
        if ($minutes = $input->getOption('lastchange-minutes')) {
            $yourProductRepository->setLastchangeMinutes($minutes);
        }*/

        /** @var \Doctrine\DBAL\Connection $gatewayConnection */
        $gatewayConnection = $this->getHelper('db')->getConnection();
        $productMapper = new ProductMapper($gatewayConnection);

        /*$affectedRows = 0;
        $countRows = 0;

        /** @var \Connector\Gateway\Entity\Product $product */
        /*foreach ($yourProductRepository->iterate() as $product) {
            $countRows++;

            $result = $productMapper->save($product);
            if ($result) {
                $affectedRows++;
            }
        }
        $output->write(sprintf(
            'Update products on %s. Count - %d, affected - %d',
            date("Y.m.d H:i:s"),
            $countRows,
            $affectedRows
        ), true);*/
    }
}