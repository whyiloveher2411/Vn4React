import { Box, Card, CardContent, Grid, Typography } from '@material-ui/core';
import { FieldForm } from 'components';
import React from 'react';
import { __p } from 'utils/i18n';

function Downloadable({ PLUGIN_NAME, post, handleOnReviewValue }) {

    return (
        <Card>
            <CardContent>
                <FieldForm
                    compoment="true_false"
                    config={{
                        title: __p('Downloadable product', PLUGIN_NAME),
                        isChecked: true
                    }}
                    post={post}
                    name="downloadable_product"
                    onReview={handleOnReviewValue('downloadable_product')}
                />
                {
                    Boolean(post.downloadable_product) &&
                    <Box display="flex" flexDirection="column" marginTop={2} gridGap={24}>
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
                            onReview={handleOnReviewValue('downloadable_files')}
                        />
                        <FieldForm
                            compoment='number'
                            config={{
                                title: __p('Download limit', PLUGIN_NAME),
                                note: __p('Leave blank for unlimited re-downloads.', PLUGIN_NAME),
                            }}
                            post={post}
                            name='downloadable_limit'
                            onReview={handleOnReviewValue('downloadable_limit')}
                        />
                        <FieldForm
                            compoment={'number'}
                            config={{
                                title: __p('Download expiry', PLUGIN_NAME),
                                note: __p('Enter the number of days before a download link expires, or leave blank.', PLUGIN_NAME)
                            }}
                            post={post}
                            name={'downloadable_expiry'}
                            onReview={handleOnReviewValue('downloadable_expiry')}
                        />
                    </Box>
                }
            </CardContent>
        </Card>
    )
}

export default Downloadable
