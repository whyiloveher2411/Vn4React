import { IconButton, Tooltip } from '@material-ui/core'
import { BarChartRounded } from '@material-ui/icons'
import React from 'react'
import { useHistory } from 'react-router';

function ActionWithPostTypeDetail({ post }) {

    const history = useHistory();

    if (post && post._permalink && post.status === 'publish') {
        return (
            <Tooltip title="The Google Analytics Reporting " aria-label="The Google Analytics Reporting ">
                <IconButton onClick={(e) => { e.stopPropagation(); history.push("/plugin/vn4-google-analytics/reports") }} style={{ color: '#1a237e', opacity: 1 }} aria-label="The Google Analytics Reporting ">
                    <BarChartRounded />
                </IconButton>
            </Tooltip>
        )
    }
    return <></>;

}

export default ActionWithPostTypeDetail
