import { numberWithSeparator } from 'utils/helper';
import { __p } from 'utils/i18n';
import { PLUGIN_NAME } from './../../../helpers/plugin';

const list_option = {
    instock: { title: __p('In stock', PLUGIN_NAME), color: '#7ad03a' },
    outofstock: { title: __p('Out of stock', PLUGIN_NAME), color: '#a44' },
    onbackorder: { title: __p('On backorder', PLUGIN_NAME), color: '#eaa600' },
};

function Quantity(props) {

    if (props.post.quantity) {

        if (props.post.product_type === 'variable') {
            return __p('{{quantity}} in stock for {{number_of_variation}} variants', PLUGIN_NAME, {
                quantity: numberWithSeparator(props.post.quantity),
                number_of_variation: props.post.number_of_variation
            });
        }

        return __p('{{quantity}} in stock', PLUGIN_NAME, {
            quantity: numberWithSeparator(props.post.quantity),
        });
    }

    if (props.post.product_type === 'variable') {
        return __p('{{quantity}} in stock for {{number_of_variation}} variants', PLUGIN_NAME, {
            quantity: 0,
            number_of_variation: props.post.number_of_variation ?? 0
        });
    }

    if (!props.post.warehouse_manage_stock) {

        return list_option[props.post.stock_status]?.title;

    } else {

        return __p('{{quantity}} in stock', PLUGIN_NAME, {
            quantity: 0,
        });

    }


}

export default Quantity
