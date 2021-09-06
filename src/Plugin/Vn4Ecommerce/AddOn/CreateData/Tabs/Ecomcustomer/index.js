import Insights from './Insights';
import Orders from './Orders';
import Reviews from './Reviews';

export default {
    insights: {
        title: 'Insights',
        component: (props) => <Insights {...props} />,
        priority: 2,
    },
    orders: {
        title: 'Orders',
        component: (props) => <Orders {...props} />,
        priority: 3,
    },
    reviews: {
        title: 'Reviews',
        component: (props) => <Reviews {...props} />,
        priority: 4,
    },
}