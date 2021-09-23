import { Grid, Typography } from '@material-ui/core'
import { Skeleton } from '@material-ui/lab'
import { FieldForm } from 'components'
import React from 'react'

function Shipments(props) {

    if (props.post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: 'Weight (kg)',
                            maxLength: 70
                        }}
                        post={props.post}
                        name='shipments_weight'
                        onReview={(value) => props.onReview(value, 'shipments_weight')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <Typography variant="body1">Dimensions (cm)</Typography>
                    <br />
                    <Grid container spacing={2}>
                        <Grid item md={4} xs={12}>
                            <FieldForm
                                compoment='number'
                                config={{
                                    title: 'Length',
                                    maxLength: 70
                                }}
                                post={props.post}
                                name='shipments_dimensions_length'
                                onReview={(value) => props.onReview(value, 'shipments_dimensions_length')}
                            />
                        </Grid>

                        <Grid item md={4} xs={12}>
                            <FieldForm
                                compoment='number'
                                config={{
                                    title: 'Width',
                                    maxLength: 70
                                }}
                                post={props.post}
                                name='shipments_dimensions_width'
                                onReview={(value) => props.onReview(value, 'shipments_dimensions_width')}
                            />
                        </Grid>

                        <Grid item md={4} xs={12}>
                            <FieldForm
                                compoment='number'
                                config={{
                                    title: 'Height',
                                    maxLength: 70
                                }}
                                post={props.post}
                                name='shipments_dimensions_height'
                                onReview={(value) => props.onReview(value, 'shipments_dimensions_height')}
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
