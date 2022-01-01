import { Box, Card, CardContent, CardHeader, LinearProgress, makeStyles, Tooltip, Typography } from '@material-ui/core';
import * as colors from '@material-ui/core/colors';
import { fade } from '@material-ui/core/styles/colorManipulator';
import { Skeleton } from '@material-ui/lab';
import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import React from 'react';
import { __p } from 'utils/i18n';
import { moneyFormat, precentFormat } from './../../../../../../helpers/Money';

const useStyles = makeStyles((theme) => ({
    linear: {
        backgroundColor: 'var(--main)',
        '& .MuiLinearProgress-bar': {
            backgroundColor: 'var(--bar)',
        }
    }
}));

function Revenue({ classes, data }) {
    const classes2 = useStyles();

    if (data) {
        return (
            <Card>
                <CardHeader
                    style={{ display: 'block' }}
                    title={__p('Revenue', PLUGIN_NAME)}
                    subheader={<Tooltip arrow title={__p('You will only receive reports related to the current product including revenue, cost, profit, tax, evaluation,...', PLUGIN_NAME)}><Typography variant='subtitle2' noWrap>{__p('All reports on this page refer only to this product', PLUGIN_NAME)}</Typography></Tooltip>}
                />
                <CardContent style={{ padding: '16px 24px 16px' }}>
                    <Box display="flex" gridGap={8} alignItems="baseline">
                        <Typography variant="h3" className={classes.valuePanel}>{moneyFormat(data.order.pricing_detail.rows.revenue)}</Typography>
                        {
                            data.order.pricing_detail.rows.order_quantity > 0 &&
                            <Typography style={{ opacity: .7 }}>
                                ({__p('{{quantity}} sold products', PLUGIN_NAME, {
                                    quantity: data.order.pricing_detail.rows.order_quantity
                                })})
                            </Typography>
                        }
                    </Box>
                    <Typography variant="body2">{__p('based on {{total}} completed orders', PLUGIN_NAME, {
                        total: data.status_rate.rows.completed ? data.status_rate.rows.completed : 0
                    })}</Typography>
                    {
                        (() => {
                            return [
                                {
                                    title: __p('Cost', PLUGIN_NAME),
                                    value: data.order.pricing_detail.rows.cost,
                                    precent: data.order.pricing_detail.rows.cost * 100 / (data.order.pricing_detail.rows.revenue > 0 ? data.order.pricing_detail.rows.revenue : 1),
                                    colorLinearProgress: colors.red[500]
                                },
                                {
                                    title: __p('Profit', PLUGIN_NAME),
                                    value: data.order.pricing_detail.rows.profit,
                                    precent: data.order.pricing_detail.rows.profit * 100 / (data.order.pricing_detail.rows.revenue > 0 ? data.order.pricing_detail.rows.revenue : 1),
                                    colorLinearProgress: colors.green[500]
                                },
                                {
                                    title: __p('Tax', PLUGIN_NAME),
                                    value: data.order.pricing_detail.rows.tax,
                                    precent: data.order.pricing_detail.rows.tax * 100 / (data.order.pricing_detail.rows.revenue > 0 ? data.order.pricing_detail.rows.revenue : 1),
                                    colorLinearProgress: colors.deepPurple[500]
                                },
                                // {
                                //     title: 'Total Discount',
                                //     value: data.order.pricing_detail.rows.discount,
                                //     precent: data.order.pricing_detail.rows.discount * 100 / (data.order.pricing_detail.rows.revenue > 0 ? data.order.pricing_detail.rows.revenue : 1),
                                //     colorLinearProgress: colors.yellow[500]
                                // },
                            ].map((item, index) => (
                                <React.Fragment key={index} >
                                    <Box display="flex" justifyContent="space-between" gridGap={16} marginTop={2} marginBottom={1}>
                                        <Typography>{item.title}</Typography>
                                        <Box display="flex" gridGap={6} alignItems="center">
                                            <Typography>{moneyFormat(item.value ? item.value : 0)}</Typography>
                                            <Typography variant='body2'>({precentFormat(item.precent ? item.precent : 0)})</Typography>
                                        </Box>
                                    </Box>
                                    <LinearProgress
                                        variant="determinate"
                                        value={item.precent ? item.precent : 0}
                                        className={classes2.linear}
                                        style={{
                                            '--bar': item.colorLinearProgress,
                                            '--main': fade(item.colorLinearProgress, 0.2),
                                        }}
                                    />
                                </React.Fragment>
                            ))
                        })()
                    }
                </CardContent>
            </Card>
        )
    }

    return (
        <Card>
            <CardContent style={{ padding: '16px 24px' }}>
                <Skeleton variant="rect" className={classes.titlePanel} width={'100%'} height={20} />
                <Skeleton variant="rect" className={classes.valuePanel} width={'100%'} height={28} />
                <Skeleton variant="rect" className={classes.valuePanel} width={'100%'} height={15} />
                <Skeleton variant="rect" className={classes.titlePanel} width={'100%'} height={20} />
                <Skeleton variant="rect" className={classes.valuePanel} width={'100%'} style={{ marginTop: 24 }} height={32} />
                <Skeleton variant="rect" className={classes.valuePanel} width={'100%'} style={{ marginTop: 20 }} height={32} />
                <Skeleton variant="rect" className={classes.valuePanel} width={'100%'} style={{ marginTop: 20 }} height={32} />
            </CardContent>
        </Card>
    )
}

export default Revenue
