import { Box, Checkbox, Grid, ListItem, ListItemIcon, ListItemText, makeStyles } from '@material-ui/core';
import CheckBoxIcon from '@material-ui/icons/CheckBox';
import CheckBoxOutlineBlankIcon from '@material-ui/icons/CheckBoxOutlineBlank';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import { Skeleton } from '@material-ui/lab';
import { AvatarCustom, FieldForm } from 'components';
import React from 'react';
import CustomViewListProductPrice from './../../../CustomViewListProductPrice';

const icon = <CheckBoxOutlineBlankIcon fontSize="small" />;
const checkedIcon = <CheckBoxIcon fontSize="small" />;

const useStyles = makeStyles((theme) => {
    return {
        root: {
            width: '100%',
            maxWidth: 360,
            backgroundColor: theme.palette.background.paper,
        },
        nested: {
            paddingLeft: theme.spacing(4),
        },
        selectProduct: {
            '& .MuiAutocomplete-endAdornment': {
                display: 'none'
            },
            '& .MuiOutlinedInput-root, & .MuiAutocomplete-inputRoot[class*="MuiOutlinedInput-root"]': {
                paddingRight: 'unset',
            },
            '& .MuiAutocomplete-inputRoot .MuiAutocomplete-input': {
                padding: '8px 16px',
                margin: 3
            }
        },
        removeProductIcon: {
            opacity: .3,
            '&:hover': {
                opacity: 1
            }
        },
        productID: {
            margin: 0,
            opacity: .4,
            fontWeight: 'bold'
        }
    }
});

const AvatarThumbnail = ({ product }) => <AvatarCustom variant="square" style={{ marginRight: 8 }} image={product.thumbnail} name={product.title} />;


function Connectedproducts(props) {

    const classes = useStyles();


    const renderOption = (option, { selected }) => (
        <Box display="flex" alignItems="center" width={1}>
            <Checkbox
                icon={icon}
                checkedIcon={checkedIcon}
                style={{ marginRight: 8 }}
                checked={selected}
                color="primary"
            />
            <AvatarThumbnail product={option} />
            <div>
                <span className={classes.productID}>(ID: {option.id})</span> {option.title}
                <CustomViewListProductPrice post={option} />
            </div>
            {Boolean(option.new_post) && <strong>&nbsp;(New Option)</strong>}
        </Box>
    );


    const renderTags = (tagValue, getTagProps) => {

        return tagValue.map((option, index) => {
            const { onDelete, ...rest } = getTagProps({ index });

            return <ListItem key={index} button {...rest}>
                <ListItemIcon >
                    <AvatarThumbnail product={option} />
                </ListItemIcon>
                <ListItemText primary={
                    <div>
                        <span className={classes.productID}>(ID: {option.id})</span> {option.title}
                        <CustomViewListProductPrice post={option} />
                    </div>
                } />
                <ClearRoundedIcon className={classes.removeProductIcon} onClick={onDelete} />
            </ListItem>
        });
    };

    if (props.post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <FieldForm
                        className={classes.selectProduct}
                        compoment='relationship_manytomany'
                        config={{
                            title: 'Up-Selling',
                            object: 'ecom_prod',
                            conditions: [
                                ['id', '!=', props.postDetail.id]
                            ],
                        }}
                        includeInputInList
                        renderTags={renderTags}
                        renderOption={renderOption}
                        disableClearable
                        disableListWrap
                        post={props.post}
                        name='connected_products_up_selling'
                        onReview={(value) => props.onReview(value, 'connected_products_up_selling')}
                    />
                </Grid>

                <Grid item md={12} xs={12}>
                    <FieldForm
                        className={classes.selectProduct}
                        compoment='relationship_manytomany'
                        config={{
                            title: 'Cross-Selling',
                            object: 'ecom_prod',
                            conditions: [
                                ['id', '!=', props.postDetail.id]
                            ],
                        }}
                        renderTags={renderTags}
                        renderOption={renderOption}
                        disableClearable
                        post={props.post}
                        name='connected_products_cross_selling'
                        onReview={(value) => props.onReview(value, 'connected_products_cross_selling')}
                    />
                </Grid>
            </Grid >
        )
    }

    return (
        <Grid
            container
            spacing={3}>
            <Grid item md={12} xs={12}>
                <Skeleton variant="rect" width={'100%'} height={52} />
                <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={30} />
                <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={30} />
                <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={30} />
                <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={30} />
            </Grid>

            <Grid item md={12} xs={12}>
                <Skeleton variant="rect" width={'100%'} height={52} />
                <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={30} />
                <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={30} />
                <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={30} />
                <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={30} />
            </Grid>
        </Grid >
    )
}

export default Connectedproducts
