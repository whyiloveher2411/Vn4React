import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import { __p } from 'utils/i18n';
import Structure from './Structure';

export default {
    structure: {
        title: __p('Structure', PLUGIN_NAME),
        component: (props) => <Structure {...props} />,
        priority: 2,
    },
}