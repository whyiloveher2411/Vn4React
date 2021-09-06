import { IconButton, Tooltip } from '@material-ui/core'
import PieChartRounded from '@material-ui/icons/PieChartRounded'
import React from 'react'
import { useHistory } from 'react-router';

function ActionWithPostTypeDetail({ post }) {

    const history = useHistory();

    if (post && post._permalink && post.status === 'publish') {
        return (
            <Tooltip title="Lighthouse performance scoring" aria-label="Lighthouse performance scoring">
                <IconButton onClick={(e) => { e.stopPropagation(); history.push("/plugin/vn4seo/measure/performance") }} style={{ color: '#43a047', opacity: 1 }} aria-label="Lighthouse performance scoring">
                    <PieChartRounded />
                </IconButton>
            </Tooltip>
        )
    }
    return <></>;
}

export default ActionWithPostTypeDetail
