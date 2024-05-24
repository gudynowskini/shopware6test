import template from './sw-product-detail-out-of-stock-notifications.html.twig';;
const {Criteria} = Shopware.Data;

Shopware.Component.register('sw-product-detail-out-of-stock-notifications', {
    inject: ['repositoryFactory'],
    template,
    notificationRepository: undefined,


    data: function () {
        return {
            entities: undefined,
            columns: [{
                property: 'email', label: 'email'
            }, {
                property: 'created_at', label: 'Created At'
            }],
            count: undefined
        }
    }, computed: {
        notificationRepository() {
            return this.repositoryFactory.create('out_of_stock_product');
        }
    },

    created() {
        const productId = this.$route.params.id;
        const criteria = new Criteria();
        criteria.addFilter(Criteria.equals('productId', productId));

        this.notificationRepository
            .search(criteria, Shopware.Context.api)
            .then(result => {
                this.entities = result;
                this.count = result.total;
            })
            .catch((e) => {
                console.error(e)
            })


    },
});