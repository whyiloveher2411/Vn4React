import React from 'react'
import { useSelector } from 'react-redux';
import { toCamelCase } from '../utils/helper';

function Hook(props) {
    const { hook, ...propsChild } = props;
    const plugins = useSelector(state => state.plugins);
    const settings = useSelector(state => state.settings);

    // const [views, setViews] = React.useState([]);

    // React.useEffect(() => {

    //     let viewsTemp = [];

    //     Object.keys(plugins).map((plugin) => (
    //         (() => {
    //             if (plugins[plugin].status === 'publish') {
    //                 try {
    //                     let compoment = toCamelCase(plugin) + '/Hook/' + hook;

    //                     let resolved = require(`./../Plugin/${compoment}`).default;

    //                     if (Number.isInteger(resolved.priority)) {
    //                         viewsTemp.splice(resolved.priority, 0, React.createElement(resolved.content, { key: plugin, plugin: plugins[plugin], ...propsChild }));
    //                     } else {
    //                         viewsTemp.push(React.createElement(resolved, { key: plugin, plugin: plugins[plugin], ...propsChild }));
    //                     }

    //                 } catch (error) {

    //                 }
    //             }
    //         })()
    //     ));

    //     try {
    //         let compoment = toCamelCase(settings.general_client_theme) + '/Hook/' + hook;
    //         let resolved = require(`./../Themes/${compoment}`).default;
    //         viewsTemp.unshift(React.createElement(resolved, { ...propsChild }));
    //     } catch (error) {

    //     }

    //     setViews(viewsTemp);
    // }, []);

    return <React.Fragment>
        {
            (() => {
                try {
                    let compoment = toCamelCase(settings.general_client_theme) + '/Hook/' + hook;
                    let resolved = require(`./../Themes/${compoment}`).default;
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
                                let compoment = toCamelCase(plugin) + '/Hook/' + hook;

                                let resolved = require(`./../Plugin/${compoment}`).default;

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
