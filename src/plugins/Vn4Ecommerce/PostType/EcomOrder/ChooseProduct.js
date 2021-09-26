import { Box, Checkbox, IconButton, ListItem, ListItemIcon, ListItemText, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Typography } from '@material-ui/core';
import CheckBoxIcon from '@material-ui/icons/CheckBox';
import CheckBoxOutlineBlankIcon from '@material-ui/icons/CheckBoxOutlineBlank';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import { AvatarCustom, Divider, FieldForm, MaterialIcon } from 'components';
import React from 'react';
import Price from './../EcomProd/Views/Price';
import Product from './../EcomProd/Views/Main';

const AvatarThumbnail = ({ product }) => <AvatarCustom variant="square" style={{ marginRight: 8 }} image={product.thumbnail} name={product.title} />;

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

function ChooseProduct(props) {

    const classes = useStyles();

    const { post, name } = props;

    const [products, setProducts] = React.useState([]);

    const renderTags = () => null;

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
                <Price post={option} />
            </div>
            {Boolean(option.new_post) && <strong>&nbsp;(New Option)</strong>}
        </Box>
    );

    React.useEffect(() => {
        let valueInital = [];
        try {
            if (post[name] && typeof post[name] === 'object') {
                valueInital = post[name];
            } else {
                if (post[name]) {
                    valueInital = JSON.parse(post[name]);
                }
            }

            if (!Array.isArray(valueInital)) valueInital = [];
        } catch (error) {
            valueInital = [];
        }

        setProducts(valueInital);
    }, []);

    return (
        <div>
            <FieldForm
                className={classes.selectProduct}
                compoment='relationship_manytomany'
                config={{
                    title: 'Products',
                    object: 'ecom_prod',
                    placeholder: 'Add Product'
                }}
                includeInputInList
                renderTags={renderTags}
                renderOption={renderOption}
                disableClearable
                disableListWrap
                post={props.post}
                name='ecom_prod'
                onReview={(value) => { props.onReview(value, 'ecom_prod'); setProducts(value) }}
            />
            {
                products.length > 0 &&
                <>
                    <TableContainer style={{ marginTop: 8 }}>
                        <Table>
                            <TableHead>
                                <TableRow>
                                    <TableCell style={{ width: 40 }}>
                                        ID
                                    </TableCell>
                                    <TableCell>
                                        Product
                                    </TableCell>
                                    <TableCell>
                                        SKU
                                    </TableCell>
                                    <TableCell style={{ width: 100 }}>
                                        Quantity
                                    </TableCell>
                                    <TableCell>
                                        Tax
                                    </TableCell>
                                    <TableCell style={{ width: 100 }}>
                                    </TableCell>
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                {
                                    products.map((item, index) => (
                                        <TableRow key={index}>
                                            <TableCell>
                                                {item.id}
                                            </TableCell>
                                            <TableCell>
                                                <Box display="flex" alignItems="center" width={1}>
                                                    <AvatarThumbnail product={item} />
                                                    <div>
                                                        {item.title}
                                                        <Price post={item} />
                                                    </div>
                                                </Box>
                                            </TableCell>
                                            <TableCell>
                                                {item.slug}
                                            </TableCell>
                                            <TableCell>
                                                <FieldForm
                                                    compoment='number'
                                                    config={{
                                                        title: false,
                                                        size: 'small'
                                                    }}
                                                    post={item}
                                                    name='quantity'
                                                    onReview={(value) => {
                                                        setProducts(prev => {
                                                            if (value < 1) value = 1;
                                                            let items = [...prev];
                                                            items[index].quantity = value;
                                                            props.onReview(items, 'ecom_prod');

                                                            return items;
                                                        });
                                                    }}
                                                />
                                            </TableCell>
                                            <TableCell>
                                            </TableCell>
                                            <TableCell>
                                                <IconButton onClick={() => {

                                                    setProducts(prev => {
                                                        let items = [...prev];
                                                        items.splice(index, 1);
                                                        props.onReview(items, 'ecom_prod');
                                                        return items;
                                                    });



                                                }}>
                                                    <ClearRoundedIcon className={classes.removeProductIcon} />
                                                </IconButton>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                }
                            </TableBody>
                        </Table>
                    </TableContainer>
                </>
            }

        </div>
    )
}

export default ChooseProduct
