<?php declare(strict_types=1);

namespace SzRandomTest\Core\Content\OutOfStockProduct;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void add(OutOfStockProductEntity $entity)
 * @method void set(string $key, OutOfStockProductEntity $entity)
 * @method OutOfStockProductEntity[] getIterator()
 * @method OutOfStockProductEntity[] getElements()
 * @method OutOfStockProductEntity|null get(string $key)
 * @method OutOfStockProductEntity|null first()
 * @method OutOfStockProductEntity|null last()
 */
class OutOfStockProductCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return OutOfStockProductEntity::class;
    }

}
