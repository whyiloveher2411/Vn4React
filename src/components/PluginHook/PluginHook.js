import React from 'react'
import { toCamelCase } from 'utils/helper';

function PluginHook({ plugin, hook }) {

    if (plugin && hook) {
        try {
            let compoment = toCamelCase(plugin) + '/' + hook;

            let resolved = require(`./../../plugins/${compoment}`).default;
            return React.createElement(resolved, {});
        } catch (error) {
            return null
        }
    }

    return null;
}

export default PluginHook
