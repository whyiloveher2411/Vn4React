import Insights from './Insights';

export default {
    insights: {
        title: 'Insights',
        component: (props) => <Insights {...props} />,
        priority: 2,
    },
    topProduct: {
        title: 'Top Products',
        component: (props) => <Insights {...props} />,
        priority: 2,
    },
}