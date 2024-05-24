<?php

declare(strict_types=1);

namespace SzRandomTest\Service;

use Shopware\Core\Content\Mail\MailException;
use Shopware\Core\Content\Mail\Service\AbstractMailService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;

final class OutOfStockNotificationHelper
{
    public function __construct(
        protected EntityRepository $outOfStockNotificationRepository,
        protected AbstractMailService $mailService,
        protected EntityRepository $salesChannelRepository,
        protected EntityRepository $productRepository
    ) {
    }

    public function sendNotifications(): void
    {
        $context = Context::createCLIContext();
        $subscribedUsers = $this->outOfStockNotificationRepository->search(new Criteria(), $context)->getEntities();
        /** @var SalesChannelEntity $salesChannel */
        $salesChannel = $this->salesChannelRepository->search((new Criteria()), $context)->first();
        if ($subscribedUsers->count() > 0) {
            foreach ($subscribedUsers as $subscribedUser) {
                $productId = $subscribedUser->getProductId();
                $product = $this->productRepository->search(new Criteria([$productId]), $context)->first();
                if ($product->getAvailableStock() > 0) {
                        $this->sendMail($subscribedUser, $salesChannel, $context);
                }
            }
        }
    }

    public function sendMail($userData, $salesChannel, $context)
    {
        $data = [
            'recipients' => [
                $userData->getEmail() => $userData->getEmail()
            ],
            'salesChannelId' => $salesChannel->getId(),
            'senderName' => 'SUNZINET',
            'subject' => 'Product is back in stock',
            'contentHtml' => 'The product you are interested in is back in stock.',
            'contentPlain' => 'The product you are interested in is back in stock.'
        ];
        try {
            $this->mailService->send(
                $data,
                $context,
            );
        } catch (\Exception $e) {
            throw new \Exception('well, it failed');
        }

    }

    public function sendNotificationById($productId): void
    {
        $context = Context::createCLIContext();
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productId', $productId));
        $subscribedUsers = $this->outOfStockNotificationRepository->search($criteria, $context)->getEntities();
        /** @var SalesChannelEntity $salesChannel */
        $salesChannel = $this->salesChannelRepository->search(new Criteria(), $context)->first();
        if ($subscribedUsers->count() > 0) {
            foreach ($subscribedUsers as $subscribedUser) {
                $productId = $subscribedUser->getProductId();
                $product = $this->productRepository->search(new Criteria([$productId]), $context)->first();
                if ($product->getAvailableStock() > 0) {
                    $this->sendMail($subscribedUser, $salesChannel, $context);
                }
            }
        }
    }

}