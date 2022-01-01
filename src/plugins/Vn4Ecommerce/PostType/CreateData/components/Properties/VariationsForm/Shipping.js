import { Card, CardContent, Grid, Typography } from '@material-ui/core';
import { FieldForm } from 'components';
import React from 'react';
import { __p } from 'utils/i18n';

function Shipping({ PLUGIN_NAME, post, handleOnReviewValue }) {

    return (
        <Card>
            <CardContent>
                <Grid container spacing={3}>
                    <Grid item md={12}>
                        <Typography variant="subtitle1" style={{ marginBottom: 8 }}>Shipping</Typography>
                        <FieldForm
                            compoment="true_false"
                            config={{
                                title: __p('Virtual product', PLUGIN_NAME),
                                isChecked: true
                            }}
                            post={post}
                            name="virtual_product"
                            onReview={handleOnReviewValue('virtual_product')}
                        />
                    </Grid>
                    {
                        !Boolean(post.virtual_product) &&
                        <>
                            <Grid item md={12} xs={12}>
                                <FieldForm
                                    compoment='number'
                                    config={{
                                        title: __p('Weight (kg)', PLUGIN_NAME),
                                        maxLength: 70
                                    }}
                                    post={post}
                                    name='shipments_weight'
                                    onReview={handleOnReviewValue('shipments_weight')}
                                />
                            </Grid>
                            <Grid item md={12} xs={12}>
                                <Typography variant="body1">{__p('Dimensions (cm)', PLUGIN_NAME)}</Typography>
                                <Grid container spacing={2}>
                                    <Grid item md={4} xs={12}>
                                        <FieldForm
                                            compoment='number'
                                            config={{
                                                title: __p('Length', PLUGIN_NAME),
                                                maxLength: 70
                                            }}
                                            post={post}
                                            name='shipments_dimensions_length'
                                            onReview={handleOnReviewValue('shipments_dimensions_length')}
                                        />
                                    </Grid>

                                    <Grid item md={4} xs={12}>
                                        <FieldForm
                                            compoment='number'
                                            config={{
                                                title: __p('Width', PLUGIN_NAME),
                                                maxLength: 70
                                            }}
                                            post={post}
                                            name='shipments_dimensions_width'
                                            onReview={handleOnReviewValue('shipments_dimensions_width')}
                                        />
                                    </Grid>

                                    <Grid item md={4} xs={12}>
                                        <FieldForm
                                            compoment='number'
                                            config={{
                                                title: __p('Height', PLUGIN_NAME),
                                                maxLength: 70
                                            }}
                                            post={post}
                                            name='shipments_dimensions_height'
                                            onReview={handleOnReviewValue('shipments_dimensions_height')}
                                        />
                                    </Grid>
                                </Grid>
                            </Grid>
                        </>
                    }
                </Grid>
            </CardContent>
        </Card>
    )
}

export default Shipping

