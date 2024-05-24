<?php
declare(strict_types=1);

namespace SzRandomTest\Storefront\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class OutOfStockNotificationController extends StorefrontController
{
    #[Route(path: '/out-of-stock-notification', name: 'frontend.example.search', defaults: ['XmlHttpRequest' => 'true'], methods: ['POST'])]
    public function load(Request $request, SalesChannelContext $context): Response
    {
        try {
            $data = [
                'email' => $context->getCustomer()?->getEmail() ?? $request->get('email'),
                'productQuantity' => (int)$request->get('productAvailableStock'),
                'productId' => $request->get('productId'),
            ];
            $this->container->get('out_of_stock_product.repository')->create([$data], $context->getContext());
        } catch (UniqueConstraintViolationException $e) {
            return new Response('You have already requested this product', Response::HTTP_CONFLICT);
        }
        return new Response('Thank you for your request!');
    }
}
