import { Box, Card, CardContent, Typography } from '@material-ui/core';
import StarRoundedIcon from '@material-ui/icons/StarRounded';
import { Skeleton } from '@material-ui/lab';
import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import React from 'react';
import { __p } from 'utils/i18n';

function Reviews({ classes, data }) {

    if (data) {
        return (
            <Card>
                <CardContent>
                    <Box display="flex" alignItems="center" gridGap={8} style={{ marginBottom: 8 }}>
                        <StarRoundedIcon style={{ color: 'rgb(244, 180, 0)', fontSize: 32 }} />
                        <Typography variant="h3" className={classes.valuePanel} style={{ margin: 0, fontSize: 32 }}>{data.review.average}</Typography>
                    </Box>
                    <Typography variant="body2">{__p('based on {{total}} approved reviews', PLUGIN_NAME, {
                        total: data.review.total
                    })}</Typography>
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
                <Skeleton variant="rect" width={'100%'} height={199} />
            </CardContent>
        </Card>
    )
}

export default Reviews
