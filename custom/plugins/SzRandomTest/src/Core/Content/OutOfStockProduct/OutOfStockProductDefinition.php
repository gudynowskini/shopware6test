<?php declare(strict_types=1);

namespace SzRandomTest\Core\Content\OutOfStockProduct;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class OutOfStockProductDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'out_of_stock_product';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return OutOfStockProductEntity::class;
    }

    public function getCollectionClass(): string
    {
        return OutOfStockProductCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('email', 'email'))->addFlags(new Required(), new PrimaryKey()),
            (new IntField('product_quantity', 'productQuantity')),
            (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new Required(), new PrimaryKey()),
            (new OneToOneAssociationField('product', 'product_id', 'id', ProductDefinition::class, false))
        ]);
    }
}
