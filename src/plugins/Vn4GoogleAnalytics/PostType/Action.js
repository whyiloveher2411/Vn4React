import { IconButton, Tooltip } from '@material-ui/core';
import { MaterialIcon } from 'components';
import React from 'react';
import { useHistory } from 'react-router';

function Action({ post }) {

    const history = useHistory();

    if (post && post._permalink && post.status === 'publish') {
        return (
            <Tooltip title="The Google Analytics Reporting " aria-label="The Google Analytics Reporting ">
                <IconButton onClick={(e) => { e.stopPropagation(); history.push("/plugin/vn4-google-analytics/reports") }}  aria-label="The Google Analytics Reporting ">
                    <MaterialIcon icon={{ custom: '<image style="width:100%;" href="/plugins/vn4-google-analytics/img/ic_analytics.svg" />' }} />
                </IconButton>
            </Tooltip>
        )
    }
    return <></>;

}

export default Action
