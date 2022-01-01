import { Box, Card, CardContent, Grid, makeStyles, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import { AvatarCustom, Divider } from 'components';
import Button from 'components/Button';
import React from 'react';
import { addClasses } from 'utils/dom';
import { copyArray } from 'utils/helper';
import { __, __p } from 'utils/i18n';
import useForm from 'utils/useForm';
import BulkEditor from './BulkEditor';
import Inventory from './VariationsForm/Inventory';
import Overview from './VariationsForm/Overview';
import Pricing from './VariationsForm/Pricing';
import Shipping from './VariationsForm/Shipping';
import Downloadable from './VariationsForm/Downloadable';


const useStyles = makeStyles(theme => ({
    variableImage: {
        width: 40,
        height: 40,
        border: '1px solid ' + theme.palette.dividerDark,
        borderRadius: 4,
        overflow: 'hidden',
        '& svg': {
            fill: theme.palette.text.secondary + ' !important',
            color: theme.palette.text.secondary + ' !important',
            backgroundColor: 'unset !important',
        }
    },
    variationItem: {
        padding: theme.spacing(1, 2),
        borderBottom: '1px solid ' + theme.palette.dividerDark,
        cursor: 'pointer',
    },
    variationItemActive: {
        backgroundColor: theme.palette.dividerDark,
    },
    variationItemRemoved: {
        opacity: .3
    },
}));

function VariationsForm({ variations, attributes, postDetail, variationIndex, handleChangeVariations, listValuesAttributes, PLUGIN_NAME }) {

    const classes = useStyles();

    const [variationKey, setVariationKey] = React.useState(variationIndex);

    const [variationsState, setVariationsState, onUpdateData] = useForm(copyArray(variations));

    const [times, setTimes] = React.useState(0);

    const openBulkEditor = React.useState(false);

    const handleToggleDeleteVariantionCurrent = () => {
        setVariationsState(prev => ({
            ...prev,
            [variationKey]: {
                ...prev[variationKey],
                delete: !prev[variationKey].delete,
            }
        }))
    }

    const handleSaveVariantions = () => {
        handleChangeVariations(variationsState);
    }


    const handleChangeVariation = (key) => () => {
        setVariationKey(key);
        setTimes(prev => prev + 1);
    }

    const handleOnReviewValue = (name) => (value) => {
        setVariationsState(prev => ({
            ...prev,
            [variationKey]: {
                ...prev[variationKey],
                [name]: value
            }
        }));
    };

    const onReview = (value, key) => {

        onUpdateData(prev => {

            if (value instanceof Function) {
                [value, key] = value(prev[variationKey]);
            }

            if (typeof key === 'object' && key !== null) {

                prev[variationKey] = {
                    ...prev[variationKey],
                    ...key
                };

            } else {
                prev[variationKey] = {
                    ...prev[variationKey],
                    [key]: value
                };
            }

            return prev;
        });
    };

    if (variationsState) {
        return (
            <>
                <Grid container spacing={3} style={{ paddingTop: 8 }}>
                    <Grid item md={3} >
                        <Box display="flex" flexDirection="column" gridGap={24} style={{ position: 'sticky', top: -4 }}>
                            <Card>
                                <CardContent>
                                    <Box display="flex" gridGap={16}>
                                        <AvatarCustom variant="square" style={{ width: 100, height: 100 }} image={postDetail.thumbnail} name={postDetail.title} />
                                        <Box display="flex" flexDirection="column" gridGap={4}>
                                            <Typography variant="subtitle1">{postDetail.title}</Typography>
                                            <Typography variant="body2">{Object.keys(variationsState).filter(key => !variationsState[key].delete).length} variants</Typography>
                                            <Button autoFocus style={{ marginTop: 4 }} color="primary" variant="contained" onClick={handleSaveVariantions}>
                                                {__('Save Changes')}
                                            </Button>
                                        </Box>
                                    </Box>
                                </CardContent>
                            </Card>
                            <Card className="custom_scroll" style={{ maxHeight: 650, overflowY: 'scroll' }}>
                                <Box display="flex" alignItems="center" justifyContent="space-between" style={{ padding: 16 }} className={classes.variationItem} >
                                    <Typography variant="subtitle1">{__p('Variants', PLUGIN_NAME)}</Typography>
                                    <Button onClick={() => openBulkEditor[1](true)} size="small" variant="outlined">{__p('Open bulk editor', PLUGIN_NAME)}</Button>
                                </Box>
                                {
                                    Object.keys(variationsState).map((key) => (
                                        <Box
                                            className={addClasses({
                                                [classes.variationItem]: true,
                                                [classes.variationItemActive]: variationsState[variationKey].key === variationsState[key].key,
                                                [classes.variationItemRemoved]: variationsState[key].delete
                                            })}
                                            display="flex"
                                            alignItems="center"
                                            gridGap={8}
                                            onClick={handleChangeVariation(key)}
                                            key={key}
                                        >
                                            <div className={classes.variableImage}>
                                                <AvatarCustom image={variationsState[key].images} variant="square" name={variationsState[key].title} />
                                            </div>
                                            <Typography>
                                                {variationsState[key].label}
                                            </Typography>
                                        </Box>
                                    ))
                                }
                            </Card>
                        </Box>
                    </Grid>
                    <Grid item md={9}>
                        <Box display="flex" flexDirection="column" gridGap={24}>

                            <Overview
                                PLUGIN_NAME={PLUGIN_NAME}
                                post={variationsState[variationKey]}
                                times={times}
                                handleOnReviewValue={handleOnReviewValue}
                                handleToggleDeleteVariantionCurrent={handleToggleDeleteVariantionCurrent}
                                listValuesAttributes={listValuesAttributes}
                            />

                            <Pricing
                                PLUGIN_NAME={PLUGIN_NAME}
                                post={variationsState[variationKey]}
                                onReview={onReview}
                            />

                            <Inventory
                                PLUGIN_NAME={PLUGIN_NAME}
                                post={variationsState[variationKey]}
                                handleOnReviewValue={handleOnReviewValue}
                            />

                            <Downloadable
                                PLUGIN_NAME={PLUGIN_NAME}
                                post={variationsState[variationKey]}
                                handleOnReviewValue={handleOnReviewValue}
                            />

                            <Shipping
                                PLUGIN_NAME={PLUGIN_NAME}
                                post={variationsState[variationKey]}
                                handleOnReviewValue={handleOnReviewValue}
                            />
                        </Box>
                    </Grid>
                </Grid>
                <BulkEditor
                    open={openBulkEditor}
                    variations={variationsState}
                    attributes={attributes}
                    onSave={(variationsChange) => {
                        setVariationsState({ ...variationsChange });
                        openBulkEditor[1](false);
                    }}
                />
            </>
        )
    }

    return (
        <Grid
            container
            spacing={3}>
            <Grid item md={12} xs={12}>
                <Skeleton variant="text" width={'100%'} height={32} />
                <br />
                <Skeleton variant="rect" width={'100%'} height={52} />
            </Grid>
            <Grid item md={12} xs={12}>
                <Grid
                    container
                    spacing={2}
                >
                    <Grid item md={12} xs={12}>
                        <Divider />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Divider />
                    </Grid>
                    < Grid item md={12} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                    </Grid>
                </Grid>
            </Grid>
        </Grid >
    )
}

export default VariationsForm