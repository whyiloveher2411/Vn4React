import React from 'react'
import { Card, CardContent, Typography } from '@material-ui/core'
import { Skeleton } from '@material-ui/lab'

function Order({ classes, data }) {

    if (data) {
        return (
            <Card>
                <CardContent>
                    <Typography variant="h5" className={classes.titlePanel}>Order count for this product</Typography>
                    <Typography variant="h3" className={classes.valuePanel}>356</Typography>
                </CardContent>
            </Card>
        )
    }

    return (
        <Card>
            <CardContent>
                <Skeleton variant="rect" className={classes.titlePanel} width={'100%'} height={20} />
                <Skeleton variant="rect" className={classes.valuePanel} width={'100%'} height={28} />
            </CardContent>
        </Card>
    )
}

export default Order
