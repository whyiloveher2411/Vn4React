import { Grid, Typography } from '@material-ui/core'
import { Skeleton } from '@material-ui/lab'
import { FieldForm } from 'components'
import React from 'react'
import { __p } from 'utils/i18n'

function Shipments({ post, onReview, PLUGIN_NAME }) {

    if (post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: __p('Weight (kg)', PLUGIN_NAME),
                            maxLength: 70
                        }}
                        post={post}
                        name='shipments_weight'
                        onReview={(value) => onReview(value, 'shipments_weight')}
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
                                onReview={(value) => onReview(value, 'shipments_dimensions_length')}
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
                                onReview={(value) => onReview(value, 'shipments_dimensions_width')}
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
                                onReview={(value) => onReview(value, 'shipments_dimensions_height')}
                            />
                        </Grid>
                    </Grid>
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
                <Grid item md={12} xs={12}>
                    <Skeleton variant="text" width={'100%'} height={20} />
                    <br />
                    <Grid container spacing={2}>
                        <Grid item md={4} xs={12}>
                            <Skeleton variant="rect" width={'100%'} height={52} />
                        </Grid>

                        <Grid item md={4} xs={12}>
                            <Skeleton variant="rect" width={'100%'} height={52} />
                        </Grid>

                        <Grid item md={4} xs={12}>
                            <Skeleton variant="rect" width={'100%'} height={52} />
                        </Grid>
                    </Grid>
                </Grid>
            </Grid>
        </Grid>
    )

}

export default Shipments
