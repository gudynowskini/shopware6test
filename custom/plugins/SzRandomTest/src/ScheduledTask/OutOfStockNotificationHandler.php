<?php declare(strict_types=1);

namespace SzRandomTest\ScheduledTask;

use Psr\Log\LoggerInterface;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use SzRandomTest\Service\OutOfStockNotificationHelper;

#[AsMessageHandler(handles: OutOfStockNotificationTask::class)]
class OutOfStockNotificationHandler extends ScheduledTaskHandler
{
    public function __construct(
        EntityRepository $scheduledTaskRepository,
        ?LoggerInterface $exceptionLogger = null,
        private readonly OutOfStockNotificationHelper $outOfStockNotificationHelper
        )
    {
        parent::__construct($scheduledTaskRepository, $exceptionLogger);
    }

    public function run(): void
    {
        try {
            $this->outOfStockNotificationHelper->sendNotifications();
        }
        catch (\Exception $e) {
            $this->exceptionLogger->error('Error: ' . $e->getMessage());
        }
    }
}