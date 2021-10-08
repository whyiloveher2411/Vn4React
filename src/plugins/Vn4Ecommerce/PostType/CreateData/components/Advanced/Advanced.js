import React from 'react'
import { FieldForm } from 'components'
import { Grid } from '@material-ui/core'
import { Skeleton } from '@material-ui/lab'
import { __p } from 'utils/i18n'

function Advanced({ PLUGIN_NAME, ...props }) {

    if (props.post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='textarea'
                        config={{
                            title: __p('Purchase note', PLUGIN_NAME),
                        }}
                        post={props.post}
                        name='advanced_purchase_note'
                        onReview={(value) => props.onReview(value, 'advanced_purchase_note')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='true_false'
                        config={{
                            title: __p('Enable reviews', PLUGIN_NAME),
                            maxLength: 70,
                            layout: 'table',
                        }}
                        post={props.post}
                        name='advanced_enable_reviews'
                        onReview={(value) => props.onReview(value, 'advanced_enable_reviews')}
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
                <Skeleton variant="text" width={'100%'} style={{ marginTop: 5 }} height={20} />
            </Grid>
            <Grid item md={12} xs={12}>
                <Skeleton variant="rect" width={'100%'} height={52} />
            </Grid>
        </Grid>
    )
}

export default Advanced
