import { Grid } from '@material-ui/core'
import React from 'react'
import FieldForm from 'components/FieldForm';

function License({ post, data, onReview }) {

    return (
        <>
            <Grid
                container
                spacing={4}>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'text'}
                        config={{
                            title: 'Secret',
                        }}
                        post={post}
                        name={'license_secret'}
                        onReview={value => onReview(value, 'license_secret')}
                    />
                </Grid>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'textarea'}
                        config={{
                            title: 'Token',
                        }}
                        post={post}
                        name={'license_token'}
                        onReview={value => onReview(value, 'license_token')}
                    />
                </Grid>
            </Grid>
        </>
    )
}

export default License
