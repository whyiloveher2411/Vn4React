import { Card, CardContent, CardHeader } from '@material-ui/core';
import IconButton from '@material-ui/core/IconButton';
import MoreVertIcon from '@material-ui/icons/MoreVert';
import { Skeleton } from '@material-ui/lab';
import React from 'react';

function ReportsSales({ data }) {

    if (data) {
        return (
            <Card>
                <CardHeader
                    action={
                        <IconButton aria-label="settings">
                            <MoreVertIcon />
                        </IconButton>
                    }
                    title="Reports Sales"
                    subheader="September 14, 2016"
                />
                <CardContent>
                    <div id="chart_reports_sales"></div>
                </CardContent>
            </Card>
        )
    }
    return (
        <Card>
            <CardHeader
                title={<Skeleton variant="rect" width={'100%'} style={{ marginBottom: 5 }} height={19} />}
                subheader={<Skeleton variant="rect" width={'100%'} height={17} />}
            />
            <CardContent>
                <Skeleton variant="rect" width={'100%'} height={200} />
            </CardContent>
        </Card>
    )
}

export default ReportsSales
