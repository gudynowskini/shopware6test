<?php declare(strict_types=1);

namespace SzRandomTest\Subscriber;

use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Content\Product\ProductEvents;
use SzRandomTest\Service\OutOfStockNotificationHelper;

class OutOfStockNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(protected OutOfStockNotificationHelper $outOfStockNotificationHelper)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductEvents::PRODUCT_WRITTEN_EVENT => 'onProductUpdate'
        ];
    }
    public function onProductUpdate(EntityWrittenEvent $event): void
    {
        $this->outOfStockNotificationHelper->sendNotificationById($event->getIds()[0]);
    }
}
