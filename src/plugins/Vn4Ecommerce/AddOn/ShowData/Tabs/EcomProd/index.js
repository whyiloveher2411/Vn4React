import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import { __p } from 'utils/i18n';
import Insights from './Insights';
import Inventory from './Inventory';

export default {
    inventory: {
        title: __p('Inventory', PLUGIN_NAME),
        component: (props) => <Inventory {...props} />,
        priority: 3,
    },
    insights: {
        title: 'Insights',
        component: (props) => <Insights {...props} />,
        priority: 4,
    },
    topProduct: {
        title: 'Top Products',
        component: (props) => <Insights {...props} />,
        priority: 5,
    },
}