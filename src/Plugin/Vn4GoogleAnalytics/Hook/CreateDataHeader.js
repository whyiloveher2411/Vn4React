import { IconButton, Tooltip } from '@material-ui/core'
import { BarChartRounded } from '@material-ui/icons'
import React from 'react'

function CreateDataHeader({ data }) {

    if (data && data.post && data.post._permalink) {
        return (
            <Tooltip title="The Google Analytics Reporting " aria-label="The Google Analytics Reporting ">
                <IconButton href={'/plugin/vn4-google-analytics/reports'} target="_blank" color="default" aria-label="The Google Analytics Reporting ">
                    <BarChartRounded />
                </IconButton>
            </Tooltip>
        )
    }
    return <></>;

}

export default CreateDataHeader
