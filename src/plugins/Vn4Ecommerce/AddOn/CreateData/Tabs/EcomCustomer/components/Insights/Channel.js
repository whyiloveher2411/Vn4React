import { Box, Card, CardContent, CardHeader } from '@material-ui/core';
import IconButton from '@material-ui/core/IconButton';
import MoreVertIcon from '@material-ui/icons/MoreVert';
import { Skeleton } from '@material-ui/lab';
import React from 'react';

function Channel({ data }) {

    if (data) {
        return (
            <Card>
                <CardHeader
                    action={
                        <IconButton aria-label="settings">
                            <MoreVertIcon />
                        </IconButton>
                    }
                    title="Channels"
                    subheader="September 14, 2016"
                />
                <CardContent>
                    <div id="chart_channel"></div>
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
                <Box display="flex" alignItems="flex-start">
                    <Skeleton variant="circle" width={200} height={200} style={{ flexShrink: 0, marginRight: 8 }} />
                    <Box display='flex' width={1} flexDirection="column" alignItems="center" >
                        <Skeleton variant="text" width={100} height={15} style={{ marginBottom: 5 }} />
                        <Skeleton variant="text" width={100} height={15} style={{ marginBottom: 5 }} />
                        <Skeleton variant="text" width={100} height={15} style={{ marginBottom: 5 }} />
                        <Skeleton variant="text" width={100} height={15} style={{ marginBottom: 5 }} />
                        <Skeleton variant="text" width={100} height={15} style={{ marginBottom: 5 }} />
                        <Skeleton variant="text" width={100} height={15} style={{ marginBottom: 5 }} />
                    </Box>
                </Box>
            </CardContent>
        </Card>
    )
}

export default Channel
