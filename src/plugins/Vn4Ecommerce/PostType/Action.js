import { IconButton, Tooltip } from '@material-ui/core';
import { MaterialIcon } from 'components';
import React from 'react';
import { useHistory } from 'react-router';
import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import { __p } from 'utils/i18n';

function Action({ post }) {

    const history = useHistory();

    if (post && (post.product_type === 'simple' || post.product_type === 'variable')) {
        return (
            <>
                <Tooltip title={__p('Inventory', PLUGIN_NAME)}>
                    <IconButton color="inherit" onClick={(e) => { e.stopPropagation(); history.push("/plugin/vn4-google-analytics/reports") }} aria-label="The Google Analytics Reporting ">
                        <MaterialIcon icon="HomeWorkOutlined" />
                    </IconButton>
                </Tooltip>
            </>
        )
    }
    return <></>;

}

export default Action
