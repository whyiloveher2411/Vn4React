import React from 'react'
import { Box, Card, CardContent, Typography } from '@material-ui/core'
import StarRoundedIcon from '@material-ui/icons/StarRounded';
import { Skeleton } from '@material-ui/lab';

function Reviews({ classes, data }) {

    if (data) {
        return (
            <Card>
                <CardContent>
                    <Box display="flex" alignItems="center" gridGap={8} style={{ marginBottom: 8 }}>
                        <StarRoundedIcon style={{ color: 'rgb(244, 180, 0)', fontSize: 32 }} />
                        <Typography variant="h3" className={classes.valuePanel} style={{ margin: 0, fontSize: 32 }}>3.94</Typography>
                    </Box>
                    <Typography variant="h5" className={classes.titlePanel}>14 reviews in total based on 122 reviews</Typography>
                    <div id="chart_reviews"></div>
                </CardContent>
            </Card>
        )
    }

    return (
        <Card>
            <CardContent>
                <Box display="flex" alignItems="center" gridGap={8} style={{ marginBottom: 8 }}>
                    <Skeleton variant="rect" style={{ color: 'rgb(244, 180, 0)', fontSize: 32 }} width={32} height={32} />
                    <Skeleton variant="rect" className={classes.valuePanel} style={{ margin: 0, fontSize: 32 }} width={'100%'} height={32} />
                </Box>
                <Skeleton variant="rect" className={classes.titlePanel} width={'100%'} height={20} />
                <Skeleton variant="rect" width={'100%'} height={277} />
            </CardContent>
        </Card>
    )
}

export default Reviews
