import { useSelector } from 'react-redux';
import { toCamelCase } from '../utils/helper';

function HookFilters({ hook, ...propsChild }) {

    const plugins = useSelector(state => state.plugins);
    const settings = useSelector(state => state.settings);

    const result = [];

    try {
        let compoment = toCamelCase(settings.general_client_theme) + '/Hook/' + hook;
        let resolved = require(`./../Themes/${compoment}`);

        result.push({ resolved: resolved, props: { ...propsChild } });
    } catch (error) {

    }

    Object.keys(plugins).map((plugin) => (
        (() => {
            if (plugins[plugin].status === 'publish') {
                try {
                    let compoment = toCamelCase(plugin) + '/Hook/' + hook;
                    let resolved = require(`./../Plugin/${compoment}`);
                    result.push({ resolved: resolved, props: { key: plugin, plugin: plugins[plugin], ...propsChild } });
                } catch (error) {

                }
            }
        })()
    ))

    return result;
}

export default HookFilters
