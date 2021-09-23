import React from 'react'
import { useSelector } from 'react-redux';
import { toCamelCase } from '../utils/helper';

function Hook(props) {
    const { hook, ...propsChild } = props;
    const plugins = useSelector(state => state.plugins);
    const settings = useSelector(state => state.settings);

    return <React.Fragment>
        {
            (() => {
                try {
                    let compoment = toCamelCase(settings.general_client_theme) + '/' + hook;
                    let resolved = require(`./../themes/${compoment}`).default;
                    return React.createElement(resolved, { ...propsChild });
                } catch (error) {

                }
            })()
        }
        {
            (() => {

                let viewsTemp = [];

                Object.keys(plugins).forEach((plugin) => (
                    (() => {
                        if (plugins[plugin].status === 'publish') {
                            try {
                                let compoment = toCamelCase(plugin) + '/' + hook;

                                let resolved = require(`./../plugins/${compoment}`).default;

                                if (Number.isInteger(resolved.priority)) {
                                    viewsTemp.splice(resolved.priority, 0, React.createElement(resolved.content, { key: plugin, plugin: plugins[plugin], ...propsChild }));
                                } else {
                                    viewsTemp.push(React.createElement(resolved, { key: plugin, plugin: plugins[plugin], ...propsChild }));
                                }

                            } catch (error) {

                            }
                        }
                    })()
                ));

                return viewsTemp.map(item => item);
            })()

        }
    </React.Fragment>
}

export default Hook
