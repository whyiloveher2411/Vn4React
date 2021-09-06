import { Grid, Typography } from '@material-ui/core';
import React from 'react'
import FieldForm from 'components/FieldForm';

function Administrator({ post, onReview }) {

    const [reRender, setRerender] = React.useState(0);

    return (
        <Grid
            container
            spacing={4} >
            <Grid item md={12} xs={12}>
                <Typography variant="h3" style={{ color: '#737373' }}>Please specify details for logging in to the Administration Area.</Typography>
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'First name',
                    }}
                    post={post}
                    name={'first_name'}
                    onReview={(value, key) => { onReview('first_name', value); setRerender(reRender + 1); }}
                />
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Last name',
                    }}
                    post={post}
                    name={'last_name'}
                    onReview={(value, key) => { onReview('last_name', value); setRerender(reRender + 1); }}
                />
            </Grid>

            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='email'
                    config={{
                        title: 'Email address',
                    }}
                    post={post}
                    name={'email_address'}
                    onReview={(value, key) => { onReview('email_address', value); setRerender(reRender + 1); }}
                />
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='password'
                    config={{
                        title: 'Admin password',
                    }}
                    post={post}
                    name={'admin_password'}
                    onReview={(value, key) => { onReview('admin_password', value); setRerender(reRender + 1); }}
                />
            </Grid>


            <Grid item md={12} xs={12}>
                <Typography variant="h3" style={{ color: '#737373' }}>Provide a custom URL for the Administration area.</Typography>
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Login URL',
                    }}
                    post={post}
                    name={'login_url'}
                    onReview={(value, key) => { onReview('login_url', value); setRerender(reRender + 1); }}
                />
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Backend URL',
                    }}
                    post={post}
                    name={'backend_url'}
                    onReview={(value, key) => { onReview('backend_url', value); setRerender(reRender + 1); }}
                />
            </Grid>
        </Grid >
    );
}

export default Administrator
