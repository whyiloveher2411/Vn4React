import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { update } from 'reducers/plugins';
import { toCamelCase } from '../utils/helper';
import { useAjax } from '../utils/useAjax';
import NotFound from './NotFound/NotFound';

function PluginPage(props) {

    const { match } = props;

    let { plugin, tab, subtab } = match.params;

    const plugins = useSelector(state => state.plugins);

    const dispatch = useDispatch();
    const { ajax, Loading, open, setOpen } = useAjax({ loadingType: 'custom' });

    if (plugin && plugins[plugin]) {

        try {

            let meta = {};

            if (plugins[plugin].meta) {
                meta = JSON.parse(plugins[plugin].meta);
            }

            if (!meta) {
                meta = {};
            }

            let compoment;
            let resolved;

            try {

                if (subtab) {
                    compoment = toCamelCase(plugin) + '/' + toCamelCase(tab) + '/' + toCamelCase(subtab);
                } else {
                    compoment = toCamelCase(plugin) + '/' + toCamelCase(tab);
                }

                resolved = require(`../plugins/${compoment}`).default;

            } catch (error) {

                compoment = toCamelCase(plugin) + '/' + toCamelCase(tab);

                resolved = require(`../plugins/${compoment}`).default;

            }

            const ajaxPluginHandle = (params) => {

                ajax({
                    url: `plugin/${plugin}/${params.url}`,
                    method: 'POST',
                    data: params.data,
                    loading: !params.notShowLoading,
                    isGetData: false,
                    success: (result) => {
                        if (result.plugin) {
                            dispatch(update({ [plugin]: result.plugin }));
                        }

                        if (params.success) {
                            params.success(result);
                        }

                    },
                    finally: () => {
                        if (params.finally) {
                            params.finally();
                        }
                    }
                });
            }

            return <>
                {React.createElement(resolved, { plugin: plugins[plugin], meta: meta, ajaxPluginHandle: ajaxPluginHandle, loading: { compoment: Loading, open: open, setOpen: setOpen } })}
            </>;

            // }
        } catch (error) {

        }
    }

    return <NotFound />;

}

export default PluginPage
