import { Box } from '@material-ui/core';
import { RedirectWithMessage } from 'components';
import React from 'react'
import { useHistory } from 'react-router-dom';
import { toCamelCase } from 'utils/helper';
import { useAjax } from 'utils/useAjax';
import { checkPermission } from 'utils/user';
import NotFound from './../NotFound/NotFound';

function TemplatesAdmin({ page, tab, subtab }) {

    const { ajax, Loading, open } = useAjax({ loadingType: 'custom' });

    const history = useHistory();

    const [template, setTemplate] = React.useState(false);
    const [notPermission, setNotPermission] = React.useState(false);
    const [data, setdata] = React.useState(false);
    const [pageNotFound, setPageNotFound] = React.useState(false);

    const loadData = () => {
        ajax({
            url: tab ? `${page}/${tab}` + (subtab ? ('/' + subtab) : '') : page + '/index',
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
                    setPageNotFound(false);
                } else {
                    setTemplate(false);
                    setdata(false);
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
    }, [page, tab, subtab]);

    if (pageNotFound) {
        return <NotFound />
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

                            return React.createElement(resolved, { ...data });

                        } catch (error) {

                            return <NotFound />

                        }

                    })()
            }
        </>
    )
}

export default TemplatesAdmin
