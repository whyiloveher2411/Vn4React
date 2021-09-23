import Insights from './Insights';

export default {
    insights: {
        title: 'Insights',
        component: (props) => <Insights {...props} />,
        priority: 2,
    },
    inProgress: {
        title: 'In Progress',
        component: (props) => <Insights {...props} />,
        priority: 2,
    },
}