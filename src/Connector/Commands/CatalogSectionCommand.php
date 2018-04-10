<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * Author: Andrey Morozov
 */

namespace Connector\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Connector\Gateway\Mappers\CatalogSectionMapper;
use Connector\RaecHttpClient;
use Connector\Gateway\Entity\CatalogSection;

class CatalogSectionCommand extends Command
{
    protected function configure()
    {
        $this->setName("connector:catalog-section")
            ->setDescription('Обновление дерева разделов каталога')
            ->setHelp(<<<EOT
Запись данных по товарам в шлюзовые таблицы B2B motion

Применение:

<info>php console.php connector:catalog-section</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->write('Catalog section synchronization started at '.date("Y.m.d H:i:s"), true);

        /** @var \Doctrine\DBAL\Connection $gatewayConnection */
        $gatewayConnection = $this->getHelper('db')->getConnection();
        $catalogSectionMapper = new CatalogSectionMapper($gatewayConnection);
        /** @var RaecHttpClient $raecClient */
        $raecClient = $this->getHelper('reacClient')->getClient();

        $affectedRows = 0;
        $countRows = 0;

        foreach ($raecClient->itrateCategories() as $categoryData) {
            $countRows++;

            $catalogSection = new CatalogSection();
            $catalogSection->setAttributes($categoryData);
            $result = $catalogSectionMapper->save($catalogSection);
            if ($result) {
                $affectedRows++;
            }
        }

        $output->write(sprintf(
            'Catalog section synchronization has done at %s. Count - %d, affected - %d',
            date("Y.m.d H:i:s"),
            $countRows,
            $affectedRows
        ), true);
    }
}