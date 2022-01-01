import Report from './Report';
import Inventory from './Inventory';
import Reviews from './Reviews';
import Customers from './Customers';
import Orders from './Orders';
import { __p } from 'utils/i18n';
import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';

export default function (props) {

    if (props.action === 'EDIT') {
        return {
            report: {
                title: __p('Report', PLUGIN_NAME),
                component: (props) => <Report {...props} />,
                priority: 2,
            },
            inventory: {
                title: __p('Inventory', PLUGIN_NAME),
                component: (props) => <Inventory {...props} />,
                priority: 3,
            },
            reviews: {
                title: __p('Reviews', PLUGIN_NAME),
                component: (props) => <Reviews {...props} />,
                priority: 4,
            },
            orders: {
                title: __p('Orders', PLUGIN_NAME),
                component: (props) => <Orders {...props} />,
                priority: 4,
            },
            // customers: {
            //     title: 'Customers',
            //     component: (props) => <Customers {...props} />,
            //     priority: 5,
            // },
        }
    }
}
