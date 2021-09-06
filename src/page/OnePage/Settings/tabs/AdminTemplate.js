import React from 'react'
import { Grid } from '@material-ui/core'
import FieldForm from 'components/FieldForm';

function AdminTemplate({ post, data, onReview }) {
    return (
        <Grid
            container
            spacing={4}>
            <Grid item md={12} xs={12} >
                <FieldForm
                    compoment={'image'}
                    config={{
                        title: 'Logo',
                    }}
                    post={post}
                    name={'admin_template_logo'}
                    onReview={value => onReview(value, 'admin_template_logo')}
                />
            </Grid>
            <Grid item md={12} xs={12} >
                <FieldForm
                    compoment={'text'}
                    config={{
                        title: 'Slogan',
                    }}
                    post={post}
                    name={'admin_template_logan'}
                    onReview={value => onReview(value, 'admin_template_logan')}
                />
            </Grid>
            <Grid item md={12} xs={12} >
                <FieldForm
                    compoment={'color'}
                    config={{
                        title: 'Color Section Left',
                    }}
                    post={post}
                    name={'admin_template_color-left'}
                    onReview={value => onReview(value, 'admin_template_color-left')}
                />
            </Grid>

            

            <Grid item md={12} xs={12} >
                <FieldForm
                    compoment={'text'}
                    config={{
                        title: 'Headline Right',
                    }}
                    post={post}
                    name={'admin_template_headline-right'}
                    onReview={value => onReview(value, 'admin_template_headline-right')}
                />
            </Grid>
        </Grid>
    )
}

export default AdminTemplate
