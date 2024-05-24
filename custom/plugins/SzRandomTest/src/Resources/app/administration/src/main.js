import './page/sw-product-detail';
import './view/sw-product-detail-out-of-stock-notifications';

Shopware.Module.register('sw-new-tab-out-of-stock-notifications', {
    routeMiddleware(next, currentRoute) {
        const customRouteName = 'sw.product.detail.out-of-stock-notifications';

        if (
            currentRoute.name === 'sw.product.detail'
            && currentRoute.children.every((currentRoute) => currentRoute.name !== customRouteName)
        ) {
            currentRoute.children.push({
                name: customRouteName,
                path: '/sw/product/detail/:id/out-of-stock-notifications',
                component: 'sw-product-detail-out-of-stock-notifications',
                meta: {
                    parentPath: 'sw.product.index',
                }
            });
        }
        next(currentRoute);
    }
});