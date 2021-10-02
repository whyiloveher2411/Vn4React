import { Box, Checkbox, IconButton, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Typography } from '@material-ui/core';
import CheckBoxIcon from '@material-ui/icons/CheckBox';
import CheckBoxOutlineBlankIcon from '@material-ui/icons/CheckBoxOutlineBlank';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import { AvatarCustom, FieldForm } from 'components';
import { moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';
import React from 'react';
import Price from './../EcomProd/Views/Price';

const AvatarThumbnail = ({ product }) => <AvatarCustom variant="square" style={{ marginRight: 8 }} image={product.thumbnail} name={product.title} />;

const icon = <CheckBoxOutlineBlankIcon fontSize="small" />;
const checkedIcon = <CheckBoxIcon fontSize="small" />;

const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
        maxWidth: 360,
        backgroundColor: theme.palette.background.paper,
    },
    table: {
        border: '1px solid',
        borderColor: theme.palette.divider
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
}));

export function calculateItemsSubtotal(prods) {
    return prods.reduce((previousValue, item) => previousValue + ((item.quantity ? parseInt(item.quantity) : 0) * (item.price ? parseInt(item.price) : 0)), 0);
}

function ChooseProduct(props) {

    const classes = useStyles();

    const { post } = props;

    const name = 'products';


    const productsInital = {
        items: [],
        total: 0
    };

    const [products, setProducts] = React.useState(productsInital);

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

        let valueInital = productsInital;
        try {
            if (post[name] && typeof post[name] === 'object') {
                valueInital = post[name];
            } else {
                if (post[name]) {
                    valueInital = JSON.parse(post[name]);
                }
            }
        } catch (error) {
            valueInital = productsInital;
        }

        setProducts(valueInital);

    }, [post.products]);

    return (
        <>
            {
                products.items?.length > 0 &&
                <TableContainer style={{ marginBottom: 8 }}>
                    <Table className={classes.table}>
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
                                <TableCell style={{ width: 40 }}>
                                    Tax
                                </TableCell>
                                <TableCell style={{ whiteSpace: 'nowrap', width: 40 }}>
                                    Row Total
                                </TableCell>
                                <TableCell style={{ width: 40 }}>
                                </TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {
                                products.items.map((item, index) => (
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
                                                        let items = { ...prev };
                                                        items.items[index].quantity = value;
                                                        items.total = calculateItemsSubtotal(items.items);
                                                        props.onReview(items, name);
                                                        return items;
                                                    });
                                                }}
                                            />
                                        </TableCell>
                                        <TableCell>
                                        </TableCell>
                                        <TableCell>
                                            {moneyFormat(item.price * item.quantity)}
                                        </TableCell>
                                        <TableCell>
                                            <IconButton onClick={() => {
                                                setProducts(prev => {
                                                    let value = { ...prev };
                                                    value.items.splice(index, 1);
                                                    value.total = calculateItemsSubtotal(value.items);

                                                    props.onReview(null, {
                                                        [name]: value,
                                                        ecom_prod: value.items,
                                                    });

                                                    return value;
                                                });
                                            }}>
                                                <ClearRoundedIcon className={classes.removeProductIcon} />
                                            </IconButton>
                                        </TableCell>
                                    </TableRow>
                                ))
                            }
                            <TableRow>
                                <TableCell colSpan={4}></TableCell>
                                <TableCell><Typography variant="h5">Total:</Typography> </TableCell>
                                <TableCell>{moneyFormat(products.total)}</TableCell>
                                <TableCell></TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </TableContainer>
            }
            <FieldForm
                className={classes.selectProduct}
                compoment='relationship_manytomany'
                config={{
                    title: 'Add Products',
                    object: 'ecom_prod',
                }}
                includeInputInList
                renderTags={() => null}
                renderOption={renderOption}
                disableClearable
                disableListWrap
                post={products}
                name='items'
                onReview={(value) => {
                    value.forEach(item => {
                        if (!item.quantity) item.quantity = 1;
                    });
                    let productState = { items: value, total: calculateItemsSubtotal(value) };
                    props.onReview(null, {
                        [name]: productState,
                        ecom_prod: value,
                    });
                    setProducts(productState)
                }}
            />
        </>
    )
}

export default ChooseProduct
