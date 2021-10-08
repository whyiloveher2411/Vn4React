import React from 'react'
import { Grid } from '@material-ui/core';
import FieldForm from 'components/FieldForm';
import { Skeleton } from '@material-ui/lab';
import { __p } from 'utils/i18n';

function Downloadable({ post, PLUGIN_NAME, onReview }) {

    if (post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='repeater'
                        config={{
                            title: __p('Downloadable files', PLUGIN_NAME),
                            sub_fields: {
                                name: { title: __p('Name', PLUGIN_NAME) },
                                fileDetail: { title: 'Field Detail', view: 'asset-file' },
                            }
                        }}
                        post={post}
                        name='downloadable_files'
                        onReview={(value) => onReview(value, 'downloadable_files')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: __p('Download limit', PLUGIN_NAME),
                            note: __p('Leave blank for unlimited re-downloads.', PLUGIN_NAME),
                        }}
                        post={post}
                        name='downloadable_limit'
                        onReview={(value) => onReview(value, 'downloadable_limit')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment={'number'}
                        config={{
                            title: __p('Download expiry', PLUGIN_NAME),
                            note: __p('Enter the number of days before a download link expires, or leave blank.', PLUGIN_NAME)
                        }}
                        post={post}
                        name={'downloadable_expiry'}
                        onReview={(value) => onReview(value, 'downloadable_expiry')}
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
        </Grid>
    )
}

export default Downloadable
