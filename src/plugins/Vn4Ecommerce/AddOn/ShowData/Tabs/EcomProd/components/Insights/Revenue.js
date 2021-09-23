import { Card, CardContent, Typography } from '@material-ui/core'
import { Skeleton } from '@material-ui/lab'
import React from 'react'

function Revenue({ classes, data }) {

    if (data) {
        return (
            <Card>
                <CardContent>
                    <Typography variant="h5" className={classes.titlePanel}>Monthly Recurring Revenue</Typography>
                    <Typography variant="h3" className={classes.valuePanel}>€ 3,200.00</Typography>
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

export default Revenue
