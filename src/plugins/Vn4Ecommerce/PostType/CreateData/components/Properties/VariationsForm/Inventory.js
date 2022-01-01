import { Card, CardContent, Grid, Typography } from '@material-ui/core';
import { FieldForm } from 'components';
import React from 'react';
import { __p } from 'utils/i18n';

function Inventory({ PLUGIN_NAME, post, handleOnReviewValue }) {

    return (
        <Card>
            <CardContent>
                <Grid container spacing={3}>
                    <Grid item md={12}>
                        <Typography variant="subtitle1">{__p('Inventory', PLUGIN_NAME)}</Typography>
                    </Grid>
                    <Grid item md={12}>
                        <FieldForm
                            compoment="text"
                            config={{
                                title: 'SKU',
                            }}
                            name="sku"
                            post={post}
                            onReview={handleOnReviewValue('sku')}
                        />
                    </Grid>
                    <Grid item md={12}>
                        <FieldForm
                            compoment='true_false'
                            config={{
                                title: __p('Manage stock?', PLUGIN_NAME),
                                note: __p('Enable stock management at variation level', PLUGIN_NAME)
                            }}
                            post={post}
                            name='warehouse_manage_stock'
                            onReview={handleOnReviewValue('warehouse_manage_stock')}
                        />
                    </Grid>
                    {
                        Boolean(post.warehouse_manage_stock) ?
                            <>
                                <Grid item md={12} xs={12}>
                                    <FieldForm
                                        compoment='number'
                                        config={{
                                            title: __p('Quantity', PLUGIN_NAME),
                                            note: __p('Stock quantity. If this is a variable product this value will be used to control stock for all variations, unless you define stock at variation level.', PLUGIN_NAME)
                                        }}
                                        post={post}
                                        name='warehouse_quantity'
                                        onReview={handleOnReviewValue('warehouse_quantity')}
                                    />
                                </Grid>
                                <Grid item md={12} xs={12}>
                                    <FieldForm
                                        compoment={'select'}
                                        config={{
                                            title: __p('Pre-order allowed?', PLUGIN_NAME),
                                            list_option: {
                                                no: { title: __p('Do not allow', PLUGIN_NAME) },
                                                notify: { title: __p('Allowed, but must notify the customer', PLUGIN_NAME) },
                                                yes: { title: __p('Allow', PLUGIN_NAME) }
                                            },
                                            note: __p('If managing inventory, this will control whether to allow pre-orders for products that are out of stock. If enabled, the number of items in stock can be set to a value below zero.', PLUGIN_NAME)
                                        }}
                                        post={post}
                                        name={'warehouse_pre_order_allowed'}
                                        onReview={handleOnReviewValue('warehouse_pre_order_allowed')}
                                    />
                                </Grid>
                                <Grid item md={12} xs={12}>
                                    <FieldForm
                                        compoment='number'
                                        config={{
                                            title: __p('Out of stock threshold', PLUGIN_NAME),
                                            maxLength: 70,
                                            note: __p('When product stock reaches this amount you will be notified by email. It is possible to define different values for each variation individually. The shop default value can be set in Settings > Products > Inventory.', PLUGIN_NAME)
                                        }}
                                        post={post}
                                        name='warehouse_out_of_stock_threshold'
                                        onReview={handleOnReviewValue('warehouse_out_of_stock_threshold')}
                                    />
                                </Grid>
                            </>
                            :
                            <Grid item md={12} xs={12}>
                                <FieldForm
                                    compoment='select'
                                    config={{
                                        title: __p('Stock status', PLUGIN_NAME),
                                        defaultValue: 'instock',
                                        list_option: {
                                            instock: { title: 'In stock', color: '#7ad03a' },
                                            outofstock: { title: 'Out of stock', color: '#a44' },
                                            onbackorder: { title: 'On backorder', color: '#eaa600' },
                                        },
                                    }}
                                    post={post}
                                    name='stock_status'
                                    onReview={handleOnReviewValue('stock_status')}
                                />
                            </Grid>
                    }
                </Grid>
            </CardContent>
        </Card>
    )
}

export default Inventory

