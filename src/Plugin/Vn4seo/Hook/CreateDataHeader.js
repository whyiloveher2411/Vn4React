import { IconButton, Tooltip } from '@material-ui/core'
import PieChartRounded from '@material-ui/icons/PieChartRounded'
import React from 'react'

function CreateDataHeader({ data }) {

    if (data && data.post && data.post._permalink) {
        return (
            <Tooltip title="Lighthouse performance scoring" aria-label="Lighthouse performance scoring">
                <IconButton href={'/plugin/vn4seo/measure/performance'} color="default" aria-label="Lighthouse performance scoring" target="_blank">
                    <PieChartRounded />
                </IconButton>
            </Tooltip>
        )
    }
    return <></>;
}

export default CreateDataHeader
