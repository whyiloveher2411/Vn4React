import { Grid, InputAdornment, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import FieldForm from 'components/FieldForm';
import { calculatePricing, moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';
import React from 'react';
import { __p } from 'utils/i18n';

function General(props) {

    const { PLUGIN_NAME, postDetail } = props;

    if (props.post) {
        return (
            <Grid
                container
                spacing={3}>
                {
                    postDetail.product_type === 'external' &&
                    <Grid item md={12} xs={12}>
                        <FieldForm
                            compoment='text'
                            config={{
                                title: __p('Product URL', PLUGIN_NAME),
                                placeholder: 'https://'
                            }}
                            post={props.post}
                            name='product_url'
                            onReview={(value) => {
                                props.onReview(value, 'product_url', true);
                            }}
                        />
                    </Grid>
                }
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
                                        ...prev.post.ecom_prod_detail,
                                        price: value
                                    })
                                }]
                            ), null, true);
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
                                        ...prev.post.ecom_prod_detail,
                                        compare_price: value
                                    })
                                }]
                            ), null, true);
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
                                        ...prev.post.ecom_prod_detail,
                                        cost: value
                                    })
                                }]
                            ), null, true);
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
                {/* <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment={'dateTime'}
                        config={{
                            title: 'Date of sale'
                        }}
                        post={props.post}
                        name={'general_date_of_sale'}
                        onReview={(value) => {
                            props.onReview(value, 'general_date_of_sale');
                        }}
                    />
                </Grid> */}
                {/* <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment={'date_range'}
                        config={{
                            title: 'Special Price From',
                            names: ['general_special_price_from', 'general_special_price_to'],
                        }}
                        post={props.post}
                        name={'general_special_price'}
                        onReview={props.onReview}
                    />
                </Grid> */}

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
                            alert(1);
                            props.onReview((prev) => (
                                [null, {
                                    ...calculatePricing({
                                        ...prev.post.ecom_prod_detail,
                                        enable_tax: value
                                    })
                                }]
                            ), null, true);
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
                                                ...prev.post.ecom_prod_detail,
                                                ...key
                                            })
                                        }];
                                    }, null, true);
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
        )
    }

    return <Grid
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
}

export default General
