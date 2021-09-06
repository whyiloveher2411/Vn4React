import { Grid, Typography } from '@material-ui/core';
import React from 'react'
import FieldForm from 'components/FieldForm';

function ConfigDatabase({ post, onReview }) {

    const [reRender, setRerender] = React.useState(0);

    return <>
        <Grid
            container
            spacing={4}>
            <Grid item md={12} xs={12}>
                <Typography variant="h3" style={{ color: '#737373' }}>Please prepare an empty database for this installation.</Typography>
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='select'
                    config={{
                        title: 'Database Type',
                        list_option: { mysql: { title: 'Mysql' } }
                    }}
                    post={post}
                    name={'database_type'}
                    onReview={(value, key) => { onReview('database_type', value); setRerender(reRender + 1); }}
                />
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Database Host',
                    }}
                    post={post}
                    name={'database_host'}
                    onReview={(value, key) => { onReview('database_host', value); setRerender(reRender + 1); }}
                />
            </Grid>

            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='number'
                    config={{
                        title: 'Database port',
                    }}
                    post={post}
                    name={'database_port'}
                    onReview={(value, key) => { onReview('database_port', value); setRerender(reRender + 1); }}
                />
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Database name',
                    }}
                    post={post}
                    name={'database_name'}
                    onReview={(value, key) => { onReview('database_name', value); setRerender(reRender + 1); }}
                />
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Database Account',
                    }}
                    post={post}
                    name={'database_account'}
                    onReview={(value, key) => { onReview('database_account', value); setRerender(reRender + 1); }}
                />
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='password'
                    config={{
                        title: 'Database password',
                        generator: false,
                    }}
                    post={post}
                    name={'database_password'}
                    onReview={(value, key) => { onReview('database_password', value); setRerender(reRender + 1); }}
                />
            </Grid>
            <Grid item md={12} xs={12}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Table prefix',
                    }}
                    post={post}
                    name={'table_prefix'}
                    onReview={(value, key) => { onReview('table_prefix', value); setRerender(reRender + 1); }}
                />
            </Grid>
        </Grid>
    </>;
}

export default ConfigDatabase
