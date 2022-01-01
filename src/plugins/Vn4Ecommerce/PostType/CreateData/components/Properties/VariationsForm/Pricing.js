import Grid from '@material-ui/core/Grid';
import InputAdornment from '@material-ui/core/InputAdornment';
import Typography from '@material-ui/core/Typography';
import Card from '@material-ui/core/Card';
import CardContent from '@material-ui/core/CardContent';
import { Skeleton } from '@material-ui/lab';
import FieldForm from 'components/FieldForm';
import { calculatePricing, moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';
import React from 'react';
import { __p } from 'utils/i18n';

function Pricing(props) {

    const { PLUGIN_NAME } = props;

    if (props.post) {
        return (
            <Card>
                <CardContent>
                    <Grid
                        container
                        spacing={3}>
                        <Grid item md={12} xs={12}>
                            <Typography variant="subtitle1" style={{ marginBottom: 8 }}>{__p('Pricing', PLUGIN_NAME)}</Typography>
                        </Grid>
                        <Grid item md={6} xs={12}>
                            <FieldForm
                                compoment='number'
                                config={{
                                    title: __p('Price', PLUGIN_NAME),
                                    note: ' ',
                                    maxLength: 70
                                }}
                                startAdornment={<InputAdornment position="start">$</InputAdornment>}
                                post={props.post}
                                name='price'
                                onReview={(value) => {
                                    props.onReview((prev) => (
                                        [null, {
                                            ...calculatePricing({
                                                ...prev,
                                                price: value
                                            })
                                        }]
                                    ));
                                }}
                            />
                        </Grid>
                        <Grid item md={6} xs={12}>
                            <FieldForm
                                compoment='number'
                                config={{
                                    title: __p('Compare at price', PLUGIN_NAME),
                                    note: ' ',
                                    maxLength: 70
                                }}
                                startAdornment={<InputAdornment position="start">$</InputAdornment>}
                                post={props.post}
                                name='compare_price'
                                onReview={(value) => {
                                    props.onReview((prev) => (
                                        [null, {
                                            ...calculatePricing({
                                                ...prev,
                                                compare_price: value
                                            })
                                        }]
                                    ));
                                }}
                            />
                        </Grid>
                        <Grid item md={6} xs={12}>
                            <FieldForm
                                compoment='number'
                                config={{
                                    title: __p('Cost per item', PLUGIN_NAME),
                                    note: __p('Customers won’t see this', PLUGIN_NAME),
                                    maxLength: 70
                                }}
                                startAdornment={<InputAdornment position="start">$</InputAdornment>}
                                post={props.post}
                                name='cost'
                                onReview={(value) => {
                                    props.onReview((prev) => (
                                        [null, {
                                            ...calculatePricing({
                                                ...prev,
                                                cost: value
                                            })
                                        }]
                                    ));
                                }}
                            />
                        </Grid>
                        <Grid item md={6} xs={12}>
                            <Grid container spacing={3}>
                                <Grid item md={4} xs={12}>
                                    <Typography variant="body2">{__p('Margin', PLUGIN_NAME)}</Typography>
                                    <Typography variant="body1">
                                        {props.post.profit_margin ?
                                            props.post.profit_margin + '%'
                                            :
                                            '-'
                                        }
                                    </Typography>
                                </Grid>
                                <Grid item md={4} xs={12}>
                                    <Typography variant="body2">{__p('Profit', PLUGIN_NAME)}</Typography>
                                    <Typography variant="body1">
                                        {props.post.profit ?
                                            moneyFormat(props.post.profit)
                                            :
                                            '-'
                                        }
                                    </Typography>
                                </Grid>
                                <Grid item md={4} xs={12}>
                                    <Typography variant="body2">{__p('Percent discount', PLUGIN_NAME)}</Typography>
                                    <Typography variant="body1">
                                        {props.post.percent_discount ?
                                            props.post.percent_discount + '%'
                                            :
                                            '-'
                                        }
                                    </Typography>
                                </Grid>
                            </Grid>
                        </Grid>

                        <Grid item md={12} xs={12}>
                            <FieldForm
                                compoment={'true_false'}
                                config={{
                                    title: __p('Charge tax on this product', PLUGIN_NAME),
                                    defaultValue: true,
                                }}
                                post={props.post}
                                name={'enable_tax'}
                                onReview={(value) => {
                                    props.onReview((prev) => (
                                        [null, {
                                            ...calculatePricing({
                                                ...prev,
                                                enable_tax: value
                                            })
                                        }]
                                    ));
                                }}
                            />
                        </Grid>
                        {
                            Boolean(props.post.enable_tax === undefined || props.post.enable_tax) &&
                            <>
                                <Grid item md={6} xs={12}>
                                    <FieldForm
                                        compoment={'relationship_onetomany'}
                                        config={{
                                            title: __p('Tax class', PLUGIN_NAME),
                                            object: 'ecom_tax',
                                        }}
                                        post={props.post}
                                        getOptionLabel={(option) => {
                                            if (option?.id) {
                                                return option.title + (option.percentage ? ' (' + Number((parseFloat(option.percentage)).toFixed(6)) + '%)' : '')
                                            }
                                            return '';
                                        }}
                                        renderOption={(option) => (
                                            <>{option.title} {option.percentage && '(' + Number((parseFloat(option.percentage)).toFixed(6)) + '%)'}</>
                                        )}
                                        name={'tax_class'}
                                        onReview={(value, key) => {
                                            props.onReview((prev) => {
                                                return [null, {
                                                    ...calculatePricing({
                                                        ...prev,
                                                        ...key
                                                    })
                                                }];
                                            });
                                        }}
                                    />
                                </Grid>
                                <Grid item md={6} xs={12}>
                                    <Typography variant="body2">{__p('Price after tax', PLUGIN_NAME)}</Typography>
                                    <Typography variant="body1">
                                        {props.post.price_after_tax ?
                                            moneyFormat(props.post.price_after_tax)
                                            :
                                            '-'
                                        }
                                    </Typography>
                                </Grid>
                            </>
                        }
                    </Grid>
                </CardContent>
            </Card>
        )
    }

    return (
        <Card>
            <CardContent>
                <Grid
                    container
                    spacing={3}>
                    <Grid item md={6} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={52} />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={52} />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={52} />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={52} />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={52} />
                    </Grid>
                </Grid>
            </CardContent>
        </Card>
    )
}

export default Pricing
