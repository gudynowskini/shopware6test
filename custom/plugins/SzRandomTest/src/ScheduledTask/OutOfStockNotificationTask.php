<?php declare(strict_types=1);

namespace SzRandomTest\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class OutOfStockNotificationTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'sz.out_of_stock_notification';
    }

    public static function getDefaultInterval(): int
    {
        return 86400;
    }
}
