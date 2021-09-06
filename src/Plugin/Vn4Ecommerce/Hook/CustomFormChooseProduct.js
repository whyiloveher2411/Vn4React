import { Box, makeStyles } from '@material-ui/core';
import { AvatarCustom, FieldForm } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import CustomViewListProductPrice from './CustomViewListProductPrice';

const useStyles = makeStyles((theme) => {
    return {
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
        productID: {
            margin: 0,
            opacity: .4,
            fontWeight: 'bold'
        }
    }
});

const AvatarThumbnail = ({ product }) => <AvatarCustom variant="square" style={{ marginRight: 8  }} image={product.thumbnail} name={product.title} />;

function CustomFormChooseProduct(props) {

    const classes = useStyles();

    const { ajax } = useAjax();

    const [productDetail, setProductDetail] = React.useState(false);

    const renderOption = (option, { selected }) => (
        <Box display="flex" alignItems="center" width={1}>
            <AvatarThumbnail product={option} />
            <div>
                <span className={classes.productID}>(ID: {option.id})</span> {option.title}
                <CustomViewListProductPrice post={option} />
            </div>
            {Boolean(option.new_post) && <strong>&nbsp;(New Option)</strong>}
        </Box>
    );

    React.useEffect(() => {

        if (props.post[props.name]) {

            ajax({
                url: 'plugin/vn4-ecommerce/create-data/get-product',
                data: {
                    id: props.post[props.name]
                },
                success: function (result) {
                    if (result.post) {
                        setProductDetail(result.post);
                    }
                }
            });
        }

    }, [props.post.id]);

    if (typeof props.post[props.name + '_detail'] === 'string') {
        props.post[props.name + '_detail'] = JSON.parse(props.post[props.name + '_detail']);
    }

    return (
        <>
            <FieldForm
                className={classes.selectProduct}
                compoment='relationship_onetomany'
                config={{
                    ...props.config,
                    title: props.config.title,
                    object: props.config.object,
                    customViewForm: null,
                }}
                includeInputInList
                renderOption={renderOption}
                disableClearable
                disableListWrap
                post={props.post}
                name={props.name}
                onReview={(value, key) => {
                    props.onReview(value, props.name);
                    setProductDetail(key[props.name + '_detail']);
                }}
            />
            {
                Boolean(productDetail) &&
                <Box display="flex" style={{ marginTop: 8, fontSize: 13 }}>
                    <div >
                        <AvatarThumbnail product={productDetail} />
                    </div>
                    <div>
                        <p style={{ marginBottom: 4, marginTop: 0 }}><span className={classes.productID}>(ID: {productDetail.id})</span> {productDetail.title}</p>
                        <CustomViewListProductPrice post={productDetail} />
                    </div>
                </Box>
            }
        </>
    )
}

export default CustomFormChooseProduct
