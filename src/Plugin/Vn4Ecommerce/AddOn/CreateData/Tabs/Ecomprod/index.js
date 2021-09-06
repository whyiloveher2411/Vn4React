import Insights from './Insights';
import Inventory from './Inventory';
import Reviews from './Reviews';
import Customers from './Customers';
import Orders from './Orders';

export default function (props) {

    if (props.action === 'EDIT') {
        return {
            insights: {
                title: 'Insights',
                component: (props) => <Insights {...props} />,
                priority: 2,
            },
            inventory: {
                title: 'Inventory',
                component: (props) => <Inventory {...props} />,
                priority: 3,
            },
            reviews: {
                title: 'Reviews',
                component: (props) => <Reviews {...props} />,
                priority: 4,
            },
            orders: {
                title: 'Orders',
                component: (props) => <Orders {...props} />,
                priority: 4,
            },
            customers: {
                title: 'Customers',
                component: (props) => <Customers {...props} />,
                priority: 5,
            },
        }
    }
}
