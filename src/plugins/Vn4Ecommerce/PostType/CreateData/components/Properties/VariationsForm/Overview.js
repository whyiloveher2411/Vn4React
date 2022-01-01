import { Box, Card, CardContent, Grid, Typography } from '@material-ui/core';
import Chip from '@material-ui/core/Chip';
import { FieldForm } from 'components';
import Button from 'components/Button';
import React from 'react';
import { __, __p } from 'utils/i18n';

function Overview({ times, post, handleOnReviewValue, listValuesAttributes, handleToggleDeleteVariantionCurrent, PLUGIN_NAME }) {
    return (
        <Card>
            <CardContent>
                <Grid container spacing={3}>
                    <Grid item md={6}>
                        <Box display="flex" flexDirection="column" gridGap={24} justifyContent="space-between" height={'100%'}>
                            <Grid container spacing={3}>
                                <Grid item md={12}>
                                    <Box display="flex" gridGap={8}>
                                        <Typography variant="subtitle1" style={{ marginBottom: 8 }}>Options: {post.label} </Typography>
                                        {
                                            Boolean(post.delete) &&
                                            <Chip
                                                size="small"
                                                label={__('Removed')}
                                                color="secondary"
                                                onDelete={handleToggleDeleteVariantionCurrent}
                                            />
                                        }
                                    </Box>
                                </Grid>
                                {
                                    post.attributes.map(attValue => (
                                        listValuesAttributes['id_' + attValue.ecom_prod_attr]?.title ?
                                            <Grid key={attValue.id} item md={12}>
                                                <FieldForm
                                                    compoment="text"
                                                    config={{
                                                        title: listValuesAttributes['id_' + attValue.ecom_prod_attr]?.title,
                                                    }}
                                                    name="name"
                                                    disabled
                                                    post={{ name: attValue.title }}
                                                    onReview={() => { }}
                                                />
                                            </Grid>
                                            :
                                            <React.Fragment key={attValue.id}></React.Fragment>
                                    ))
                                }

                                <Grid item md={12}>
                                    <FieldForm
                                        compoment="text"
                                        config={{
                                            title: 'Title',
                                        }}
                                        name="title"
                                        post={post}
                                        onReview={handleOnReviewValue('title')}
                                    />
                                </Grid>
                                {/* <Grid item md={12}>
                                    <FieldForm
                                        compoment="textarea"
                                        config={{
                                            title: __('Description'),
                                        }}
                                        name="description"
                                        post={post}
                                        onReview={handleOnReviewValue('description')}
                                    />
                                </Grid> */}
                            </Grid>
                            <Box flexShrink={0} display="flex" gridGap={8}>
                                {
                                    post.delete ?
                                        <Button color="success" onClick={handleToggleDeleteVariantionCurrent} variant="contained" >{__('Restore')}</Button>
                                        :
                                        <Button color="secondary" onClick={handleToggleDeleteVariantionCurrent} variant="contained" >{__('Delete')}</Button>
                                }
                            </Box>
                        </Box>
                    </Grid>
                    <Grid item md={6}>
                        {
                            times % 2 === 0 ?
                                <FieldForm
                                    compoment="image"
                                    times={times}
                                    config={{
                                        title: 'Images',
                                        multiple: true,
                                        widthThumbnail: '120px',
                                    }}
                                    name="images"
                                    post={post}
                                    onReview={handleOnReviewValue('images')}
                                />
                                :
                                <div>
                                    <FieldForm
                                        compoment="image"
                                        times={times}
                                        config={{
                                            title: 'Images',
                                            multiple: true,
                                            widthThumbnail: '120px',
                                        }}
                                        name="images"
                                        post={post}
                                        onReview={handleOnReviewValue('images')}
                                    />
                                </div>
                        }

                    </Grid>
                </Grid>
            </CardContent>
        </Card>
    )
}

export default Overview
