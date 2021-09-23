import { Grid } from '@material-ui/core'
import React from 'react'
import { FieldForm } from 'components'
import { Skeleton } from '@material-ui/lab'

function Warehouse(props) {

    if (props.post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='text'
                        config={{
                            title: 'SKU',
                            maxLength: 70,
                            note: 'In the field of inventory management, a stock keeping unit is a distinct type of item for sale, such as a product or service, and all attributes associated with the item type that distinguish it from other item types.'
                        }}
                        post={props.post}
                        name='warehouse_sku'
                        onReview={(value) => props.onReview(value, 'warehouse_sku')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: 'Quantity',
                            note: 'Stock quantity. If this is a variable product this value will be used to control stock for all variations, unless you define stock at variation level.'
                        }}
                        post={props.post}
                        name='warehouse_quantity'
                        onReview={(value) => props.onReview(value, 'warehouse_quantity')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment={'select'}
                        config={{
                            title: 'Pre-order allowed?',
                            list_option: {
                                no: { title: 'Do not allow' },
                                notify: { title: 'Allowed, but must notify the customer' },
                                yes: { title: 'Allow' }
                            },
                            note: 'If managing inventory, this will control whether to allow pre-orders for products that are out of stock. If enabled, the number of items in stock can be set to a value below zero.'
                        }}
                        post={props.post}
                        name={'warehouse_pre_order_allowed'}
                        onReview={(value) => props.onReview(value, 'warehouse_pre_order_allowed')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: 'Out of stock threshold',
                            maxLength: 70,
                            note: 'When product stock reaches this amount you will be notified by email. It is possible to define different values for each variation individually. The shop default value can be set in Settings > Products > Inventory.'
                        }}
                        post={props.post}
                        name='warehouse_out_of_stock_threshold'
                        onReview={(value) => props.onReview(value, 'warehouse_out_of_stock_threshold')}
                    />
                </Grid>
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
