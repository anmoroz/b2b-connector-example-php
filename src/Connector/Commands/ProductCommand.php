<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Commands;

use Connector\Gateway\Entity\Product;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use Connector\Exceptions\ConnectorException;
use Connector\RaecHttpClient;
use Connector\Helper\Lock;
use Connector\Gateway\Repository\ProductRepository as GatewayProductRepository;
use Connector\Gateway\EntityDTO\ProductDTO;
use Connector\Gateway\ProductSynchronization;

/**
 * Class ProductCommand
 * @package Connector\Commands
 */
class ProductCommand extends Command
{
    /**
     * @var GatewayProductRepository
     */
    private $gatewayProductRepository;

    /**
     * @var ProductSynchronization
     */
    private $productSynchronization;

    /**
     * @var Lock
     */
    private $lock;

    protected function configure()
    {
        $this->setName("connector:product")
            ->setDescription('Обновление товаров')
            ->setDefinition([
                new InputOption(
                    'days-from',
                    'df',
                    InputOption::VALUE_OPTIONAL,
                    'Синхронизация товаров, измененных за последние d дней'
                )
            ])
            ->setHelp(<<<EOT
Запись данных по товарам в шлюзовые таблицы B2B motion

Применение:

<info>php console.php connector:product --days-from=1</info>
EOT
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws ConnectorException
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        /** @var \Doctrine\DBAL\Connection $gatewayConnection */
        $gatewayConnection = $this->getHelper('db')->getConnection();

        $this->lock = new Lock($gatewayConnection, __CLASS__);
        if (false === $this->lock->isFreeLock()) {
            throw new ConnectorException('Running another RAEC synchronization process');
        }
        $this->lock->setLock();

        $output->write('Product update started at '.date("Y.m.d H:i:s"), true);

        $this->gatewayProductRepository  = new GatewayProductRepository($gatewayConnection);
        $this->productSynchronization = new ProductSynchronization($gatewayConnection);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RaecHttpClient $raecClient */
        $raecClient = $this->getHelper('reacClient')->getClient();

        $days = $input->getOption('days-from');
        if ($days > 0) {
            $raecClient->setFromDays($days);
        }

        $countRows = 0;
        $affectedRows = 0;
        /** @var ProductDTO $productDTO */
        foreach ($raecClient->iterate() as $productDTO) {
            $countRows++;

            /** @var Product|null $product */
            $product = $this->gatewayProductRepository->findByExternalId($productDTO->externalId);
            if (!$product) {
                $product = new Product();
                $product->setArticle($productDTO->article);
                $product->setExternalId($productDTO->externalId);
            }

            $result = $this->productSynchronization->process($productDTO, $product);
            if ($result) {
                $affectedRows++;
            }
        }
        $output->write(sprintf(
            'Product update has done at %s. Count - %d, affected - %d',
            date("Y.m.d H:i:s"),
            $countRows,
            $affectedRows
        ), true);
    }
}