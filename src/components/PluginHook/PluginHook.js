import React from 'react'
import { toCamelCase } from '../../utils/helper';

function PluginHook({ plugin, hook }) {

    if (plugin && hook) {
        try {
            let compoment = toCamelCase(plugin) + '/Hook/' + hook;

            let resolved = require(`./../../Plugin/${compoment}`).default;
            return React.createElement(resolved, { className: 'sdfsdf' });
        } catch (error) {
            return null
        }
    }

    return null;
}

export default PluginHook
