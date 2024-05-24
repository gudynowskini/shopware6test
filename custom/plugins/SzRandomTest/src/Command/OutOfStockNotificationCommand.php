<?php declare(strict_types=1);

namespace SzRandomTest\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SzRandomTest\Service\OutOfStockNotificationHelper;

#[AsCommand(
    name: 'sz-commands:out-of-stock-notification',
    description: 'Add a short description for your command',
)]
class OutOfStockNotificationCommand extends Command
{
    public function __construct(
        private readonly OutOfStockNotificationHelper $outOfStockNotificationHelper)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->outOfStockNotificationHelper->sendNotifications();
        }
        catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return 1;
        }
        $output->writeln('Notifications sent successfully');
        return 0;
    }
}
