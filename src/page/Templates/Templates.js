import { Box } from '@material-ui/core';
import { RedirectWithMessage } from 'components';
import React from 'react';
import { useHistory } from 'react-router-dom';
import { toCamelCase } from 'utils/helper';
import { useAjax } from 'utils/useAjax';
import { checkPermission } from 'utils/user';
import NotFound from '../NotFound/NotFound';

function Templates({ plugin, tab, subtab, pluginDetail }) {

    const { ajax, Loading, open } = useAjax({ loadingType: 'custom' });

    const history = useHistory();

    const [template, setTemplate] = React.useState(false);
    const [notPermission, setNotPermission] = React.useState(false);
    const [data, setdata] = React.useState(false);
    const [pageNotFound, setPageNotFound] = React.useState(false);

    const loadData = () => {
        ajax({
            url: `plugin/${plugin}/${tab}` + (subtab ? ('/' + subtab) : '/index'),
            data: {
                action: 'getDataScreen'
            },
            success: (result) => {

                if (result.permission && !checkPermission(result.permission)) {
                    setNotPermission(true);
                    return;
                }

                if (result.template) {
                    setTemplate(result.template);
                    setdata(result.data);
                } else {
                    setPageNotFound(true);
                }

            },
            error: (response) => {
                history.push('/error' + response.status);
            }
        });
    };

    React.useEffect(() => {
        loadData();
    }, [plugin, tab, subtab]);

    if (pageNotFound) {
        return <RedirectWithMessage message="Page Not Found!" code="404" />
    }

    if (notPermission) {
        return <RedirectWithMessage />
    }

    return (
        <>
            {
                open ?
                    <Box width={1} style={{ minHeight: 500 }} display="flex" alignItems="center" justifyContent="center">
                        {Loading}
                    </Box>
                    :
                    (() => {

                        if (!template || !data) return null;

                        try {
                            let compoment = toCamelCase(template);

                            let resolved = require(`./components/${compoment}`).default;

                            return React.createElement(resolved, { key: plugin, plugin: pluginDetail, ...data });

                        } catch (error) {

                            return <NotFound />

                        }

                    })()
            }
        </>
    )
}

export default Templates
