import React from 'react'
import { Grid } from '@material-ui/core';
import FieldForm from 'components/FieldForm';
import { Skeleton } from '@material-ui/lab';

function Downloadable(props) {

    if (props.post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='repeater'
                        config={{
                            title: 'Downloadable files',
                            note: 'Leave blank for unlimited re-downloads.',
                            sub_fields: {
                                name: { title: 'Name' },
                                fileDetail: { title: 'Field Detail', view: 'asset-file' },
                            }
                        }}
                        post={props.post}
                        name='downloadable_files'
                        onReview={(value) => props.onReview(value, 'downloadable_files')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: 'Download limit',
                            note: 'Leave blank for unlimited re-downloads.',
                        }}
                        post={props.post}
                        name='downloadable_limit'
                        onReview={(value) => props.onReview(value, 'downloadable_limit')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment={'number'}
                        config={{
                            title: 'Download expiry',
                            note: 'Enter the number of days before a download link expires, or leave blank.'
                        }}
                        post={props.post}
                        name={'downloadable_expiry'}
                        onReview={(value) => props.onReview(value, 'downloadable_expiry')}
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
