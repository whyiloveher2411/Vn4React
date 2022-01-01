import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import { __p } from 'utils/i18n';
import InProgress from './InProgress';
import Report from './Report';

export default {
    inProgress: {
        title: __p('In Progress', PLUGIN_NAME),
        component: (props) => <InProgress {...props} />,
        priority: 2,
    },
    report: {
        title: __p('Report', PLUGIN_NAME),
        component: (props) => <Report {...props} />,
        priority: 2,
    },
}