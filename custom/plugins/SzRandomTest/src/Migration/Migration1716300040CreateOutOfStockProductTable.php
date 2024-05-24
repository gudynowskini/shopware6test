<?php declare(strict_types=1);

namespace SzRandomTest\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1716300040CreateOutOfStockProductTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1716300040;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `out_of_stock_product` (
    `id` BINARY(16) NOT NULL,
    `email` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `product_quantity` VARCHAR(255) COLLATE utf8mb4_unicode_ci,
    `product_id` BINARY(16) NOT NULL,
     CONSTRAINT `fk.out_of_stock_product.product_id` FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3),
    PRIMARY KEY (`id`,`email`,`product_id`),
    UNIQUE KEY (`email`,`product_id`)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;
SQL;

        $connection->executeStatement($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
