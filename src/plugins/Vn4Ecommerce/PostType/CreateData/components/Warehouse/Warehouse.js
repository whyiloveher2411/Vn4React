import { Divider, Grid } from '@material-ui/core'
import { Skeleton } from '@material-ui/lab'
import { FieldForm } from 'components'
import React from 'react'
import { __p } from 'utils/i18n'

function Warehouse({ post, onReview, PLUGIN_NAME }) {

    if (post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='text'
                        config={{
                            title: __p('SKU', PLUGIN_NAME),
                            maxLength: 70,
                            note: __p('In the field of inventory management, a stock keeping unit is a distinct type of item for sale, such as a product or service, and all attributes associated with the item type that distinguish it from other item types.', PLUGIN_NAME)
                        }}
                        post={post}
                        name='warehouse_sku'
                        onReview={(value) => onReview(value, 'warehouse_sku')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <Divider />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='true_false'
                        config={{
                            title: __p('Manage stock?', PLUGIN_NAME),
                            note: __p('Enable stock management at product level', PLUGIN_NAME)
                        }}
                        post={post}
                        name='warehouse_manage_stock'
                        onReview={(value) => onReview(value, 'warehouse_manage_stock')}
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
                                    onReview={(value) => onReview(value, 'warehouse_quantity')}
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
                                    onReview={(value) => onReview(value, 'warehouse_pre_order_allowed')}
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
                                    onReview={(value) => onReview(value, 'warehouse_out_of_stock_threshold')}
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
                                        instock: { title: __p('In stock', PLUGIN_NAME), color: '#7ad03a' },
                                        outofstock: { title: __p('Out of stock', PLUGIN_NAME), color: '#a44' },
                                        onbackorder: { title: __p('On backorder', PLUGIN_NAME), color: '#eaa600' },
                                    },
                                }}
                                post={post}
                                name='stock_status'
                                onReview={(value) => onReview(value, 'stock_status')}
                            />
                        </Grid>
                }
            </Grid>
        )
    }

    return (
        <Grid
            container
            spacing={3}>
            <Grid item md={12} xs={12}>
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
    )
}

export default Warehouse
