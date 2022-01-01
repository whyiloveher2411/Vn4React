import { Box, Button, Checkbox, IconButton, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Typography } from '@material-ui/core';
import CheckBoxIcon from '@material-ui/icons/CheckBox';
import CheckBoxOutlineBlankIcon from '@material-ui/icons/CheckBoxOutlineBlank';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import { AvatarCustom, DialogCustom, DrawerCustom, FieldForm } from 'components';
import CloseIcon from '@material-ui/icons/Close';
import { moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';
import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import React from 'react';
import { __, __p } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import Quantity from '../EcomProd/Views/Quantity';
import Price from './../EcomProd/Views/Price';

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
    },
    tableVariation: {
        '& .MuiTableCell-root': {
            whiteSpace: 'nowrap'
        }
    },
    nowrap: {
        whiteSpace: 'nowrap'
    }
}));

const list_option = {
    instock: { title: __p('In stock', PLUGIN_NAME), color: '#7ad03a' },
    outofstock: { title: __p('Out of stock', PLUGIN_NAME), color: '#a44' },
    onbackorder: { title: __p('On backorder', PLUGIN_NAME), color: '#eaa600' },
};

const list_option_pre_order = {
    no: { title: __p('Do not allow', PLUGIN_NAME) },
    notify: { title: __p('Allowed, but must notify the customer', PLUGIN_NAME) },
    yes: { title: __p('Allow', PLUGIN_NAME) }
};

const getQuantityVariation = (variation) => {

    if (variation.warehouse_manage_stock) {

        if (parseInt(variation.warehouse_quantity) > 0) {
            return {
                title: variation.warehouse_quantity,
                allow_order: true,
            };
        }

        if (
            variation.warehouse_pre_order_allowed === 'notify'
            || variation.warehouse_pre_order_allowed === 'yes'
        ) {
            return {
                title: '0 - ' + list_option_pre_order[variation.warehouse_pre_order_allowed].title,
                allow_order: true,
            };
        }

        return {
            title: '0',
            allow_order: false,
        };

    } else {

        if (variation.stock_status === 'outofstock') {
            return {
                title: list_option.outofstock.title,
                allow_order: false,
            };
        }

        if (list_option[variation.stock_status]) {
            return {
                title: list_option[variation.stock_status].title,
                allow_order: true,
            };
        }

        return {
            title: list_option.instock.title,
            allow_order: true,
        };
    }
}

export function calculateItemsSubtotal(prods) {

    return prods.reduce((previousValue, item) => {

        if (item.product_type === 'variable') {

            let totalVariable = 0;

            if (item.variations?.length > 0) {
                item.variations.forEach(variation => {

                    let quantity = variation.order_quantity ? parseInt(variation.order_quantity) : 0;
                    let price = variation.price ? parseFloat(variation.price) : 0;
                    let tax = parseFloat(variation.tax) > 0 ? parseFloat(variation.tax) * quantity : 0;

                    totalVariable += (quantity * price + tax);
                });

                return previousValue + totalVariable;
            }

            return previousValue;
        }

        let quantity = item.order_quantity ? parseInt(item.order_quantity) : 0;
        let price = item.price ? parseFloat(item.price) : 0;
        let tax = parseFloat(item.tax) > 0 ? parseFloat(item.tax) * quantity : 0;

        return previousValue + (quantity * price + tax);

    }, 0);
}

function ChooseProduct(props) {

    const classes = useStyles();

    const ajaxAddVariable = useAjax();

    const { post } = props;

    const name = 'products';

    const [dataDialogVariation, setDataDialogVariation] = React.useState({
        open: false,
        items: {}
    });

    const productsInital = {
        items: [],
        total: 0
    };

    const [products, setProducts] = React.useState(productsInital);

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

        if (valueInital.items?.length > 0) {
            valueInital.total = calculateItemsSubtotal(valueInital.items);
            props.onReview(null, {
                [name]: valueInital,
                ecom_prod: valueInital.items,
            });
        }

        setProducts(valueInital);

    }, [post.products]);

    const handleClickAddVariable = (product, index) => (e) => {
        // console.log(product.variations);

        ajaxAddVariable.ajax({
            url: 'plugin/vn4-ecommerce/product-detail/get',
            method: 'POST',
            data: {
                id: product.id
            },
            success: (result) => {
                if (result.items) {

                    console.log(result);
                    console.log(product.variations);

                    if (product.variations?.length > 0) {
                        product.variations.forEach(item => {
                            if (result.items['KEY_' + item.key]) {
                                result.items['KEY_' + item.key].isSelect = true;
                                result.items['KEY_' + item.key].order_quantity = item.order_quantity;
                            }
                        });
                    }

                    setDataDialogVariation({ productIndex: index, items: result.items, open: true });
                }
            }
        });

        // setDataDialogVariation(prev => ({ ...prev, open: true }));
    }

    const handleSelectedVariation = (key, isSelect) => () => {
        setDataDialogVariation(prev => ({
            ...prev,
            items: {
                ...prev.items,
                [key]: {
                    ...prev.items[key],
                    isSelect: isSelect,
                }
            }
        }));
    }

    const handleSaveChangeVariation = () => {

        setDataDialogVariation(prevDataVariation => {

            setProducts(prevProducts => {

                let productVariationIsSelect = [];

                Object.keys(prevDataVariation.items).forEach(key => {
                    if (prevDataVariation.items[key].isSelect) {
                        delete prevDataVariation.items[key].isSelect;
                        productVariationIsSelect.push({
                            ...prevDataVariation.items[key],
                            order_quantity: prevDataVariation.items[key].order_quantity ? prevDataVariation.items[key].order_quantity : 1,
                        });
                    }
                });

                prevProducts.items[prevDataVariation.productIndex].variations = productVariationIsSelect;

                prevProducts.total = calculateItemsSubtotal(prevProducts.items);

                props.onReview(null, {
                    [name]: { ...prevProducts },
                });

                return { ...prevProducts };
            });

            return { ...prevDataVariation, open: false };
        });
    }
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
                                <TableCell style={{ width: 40 }}>
                                    Price
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
                                    item.product_type === 'variable'
                                        ?
                                        <React.Fragment key={index}>
                                            <TableRow>
                                                <TableCell>
                                                    {item.id}
                                                </TableCell>
                                                <TableCell colSpan={100}>
                                                    <Box display="flex" alignItems="center" justifyContent="space-between">
                                                        <Box display="flex" alignItems="center" width={1}>
                                                            <AvatarCustom variant="square" style={{ marginRight: 8 }} name={item.title} image={item.thumbnail} />
                                                            <div>
                                                                {item.title}
                                                                <Price post={item} />
                                                            </div>
                                                        </Box>
                                                        <Box display="flex" alignItems="center" gridGap={16}>
                                                            <Button
                                                                onClick={handleClickAddVariable(item, index)}
                                                                color="primary"
                                                                variant="contained">
                                                                {__p('Add variable', PLUGIN_NAME)}
                                                            </Button>
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
                                                        </Box>
                                                    </Box>

                                                </TableCell>
                                            </TableRow>
                                            {
                                                item.variations ?
                                                    item.variations.map((variation, index2) => (
                                                        <TableRow key={index2}>
                                                            <TableCell>

                                                            </TableCell>
                                                            <TableCell>
                                                                <Box display="flex" alignItems="center" width={1}>
                                                                    <AvatarCustom variant="square" style={{ marginRight: 8 }} name={variation.title} image={variation.images} />
                                                                    <div>
                                                                        {variation.title}
                                                                        <Price post={variation} />
                                                                    </div>
                                                                </Box>
                                                            </TableCell>
                                                            <TableCell>
                                                                {variation.sku}
                                                            </TableCell>
                                                            <TableCell>
                                                                <FieldForm
                                                                    compoment='number'
                                                                    config={{
                                                                        title: false,
                                                                        size: 'small',
                                                                        forceRender: true,
                                                                    }}
                                                                    post={variation}
                                                                    name='order_quantity'
                                                                    onReview={(value) => {

                                                                        setProducts(prev => {

                                                                            if (value < 1) value = 1;

                                                                            prev.items[index].variations[index2].order_quantity = value;

                                                                            prev.total = calculateItemsSubtotal(prev.items);

                                                                            props.onReview(prev, name);

                                                                            return { ...prev };

                                                                        });

                                                                    }}
                                                                />
                                                            </TableCell>
                                                            <TableCell className={classes.nowrap}>
                                                                {
                                                                    parseFloat(variation.tax) > 0 &&
                                                                    moneyFormat(variation.tax * variation.order_quantity)
                                                                }
                                                            </TableCell>
                                                            <TableCell className={classes.nowrap}>
                                                                {moneyFormat(variation.price * variation.order_quantity)}
                                                            </TableCell>
                                                            <TableCell className={classes.nowrap}>
                                                                {
                                                                    moneyFormat(
                                                                        variation.price * variation.order_quantity
                                                                        +
                                                                        (
                                                                            parseFloat(variation.tax) > 0 ?
                                                                                (variation.tax * variation.order_quantity)
                                                                                :
                                                                                0
                                                                        )
                                                                    )
                                                                }
                                                            </TableCell>
                                                            <TableCell>
                                                                <IconButton onClick={() => {
                                                                    setProducts(prev => {
                                                                        let items = { ...prev };
                                                                        items.items[index].variations.splice(index2, 1);
                                                                        items.total = calculateItemsSubtotal(items.items);
                                                                        props.onReview(items, name);
                                                                        return items;
                                                                    });

                                                                }}>
                                                                    <ClearRoundedIcon className={classes.removeProductIcon} />
                                                                </IconButton>
                                                            </TableCell>
                                                        </TableRow>
                                                    ))
                                                    :
                                                    <></>
                                            }
                                        </React.Fragment>
                                        :
                                        <TableRow key={index}>
                                            <TableCell>
                                                {item.id}
                                            </TableCell>
                                            <TableCell>
                                                <Box display="flex" alignItems="center" width={1}>
                                                    <AvatarCustom variant="square" style={{ marginRight: 8 }} name={item.title} image={item.thumbnail} />
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
                                                        size: 'small',
                                                        forceRender: true,
                                                    }}
                                                    post={item}
                                                    name='order_quantity'
                                                    onReview={(value) => {
                                                        setProducts(prev => {
                                                            if (value < 1) value = 1;
                                                            prev.items[index].order_quantity = value;
                                                            prev.total = calculateItemsSubtotal(prev.items);
                                                            props.onReview(prev, name);
                                                            return { ...prev };
                                                        });
                                                    }}
                                                />
                                            </TableCell>
                                            <TableCell className={classes.nowrap}>
                                                {
                                                    parseFloat(item.tax) > 0 &&
                                                    moneyFormat(item.tax * item.order_quantity)
                                                }
                                            </TableCell>
                                            <TableCell className={classes.nowrap}>
                                                {moneyFormat(item.price * item.order_quantity)}
                                            </TableCell>
                                            <TableCell className={classes.nowrap}>
                                                {
                                                    moneyFormat(
                                                        item.price * item.order_quantity
                                                        +
                                                        (
                                                            parseFloat(item.tax) > 0 ?
                                                                (item.tax * item.order_quantity)
                                                                :
                                                                0
                                                        )
                                                    )
                                                }
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
                                <TableCell colSpan={5}></TableCell>
                                <TableCell><Typography variant="h5">Total:</Typography> </TableCell>
                                <TableCell className={classes.nowrap}>{moneyFormat(products.total)}</TableCell>
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
                renderOption={(option, { selected }) => (
                    <Box display="flex" alignItems="center" width={1} gridGap={8}>
                        <Checkbox
                            icon={icon}
                            checkedIcon={checkedIcon}
                            checked={selected}
                            color="primary"
                        />
                        <AvatarCustom variant="square" style={{ marginRight: 8 }} name={option.title} image={option.thumbnail} />
                        <div>
                            <Box display="flex" alignItems="center" width={1} gridGap={4}>
                                <span className={classes.productID}>#{option.id}</span> {option.title}
                                <Typography variant='body2'>
                                    (<Quantity post={option} />)
                                </Typography>
                            </Box>
                            <Price post={option} />
                        </div>
                        {
                            Boolean(option.new_post) &&
                            <strong>&nbsp;(New Option)</strong>
                        }
                    </Box>
                )}
                getOptionDisabled={(option) =>
                    option.stock_status === 'outofstock'
                }
                disableClearable
                disableListWrap
                post={products}
                name='items'
                onReview={(value) => {
                    value.forEach(item => {
                        if (!item.order_quantity) item.order_quantity = 1;
                    });
                    let productState = { items: value, total: calculateItemsSubtotal(value) };

                    props.onReview(null, {
                        [name]: productState,
                        ecom_prod: value,
                    });
                    setProducts(productState)
                }}
            />
            <DrawerCustom
                open={dataDialogVariation.open}
                onClose={() => setDataDialogVariation(prev => ({ ...prev, open: false }))}
                headerAction={
                    <Button onClick={handleSaveChangeVariation} variant="contained" color="primary">{__('Save Changes')}</Button>
                }
                title={__p('Choose a variant to add to your order', PLUGIN_NAME)}
                width={1440}
            >
                <Table size="small" className={classes.tableVariation} >
                    <TableHead>
                        <TableRow>
                            <TableCell>{__p('Variant', PLUGIN_NAME)}</TableCell>
                            <TableCell style={{ width: 40 }} padding='none'></TableCell>
                            <TableCell>{__p('Name', PLUGIN_NAME)}</TableCell>
                            <TableCell>{__p('SKU', PLUGIN_NAME)}</TableCell>
                            <TableCell style={{ width: 40 }} >{__p('Price', PLUGIN_NAME)}</TableCell>
                            <TableCell>{__p('Inventory', PLUGIN_NAME)}</TableCell>
                            <TableCell></TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {
                            dataDialogVariation.items &&
                            Object.keys(dataDialogVariation.items).map(key => (
                                !dataDialogVariation.items[key].delete ?
                                    <TableRow key={key}>
                                        <TableCell>{dataDialogVariation.items[key].label}</TableCell>
                                        <TableCell>
                                            <div className={classes.variableImage}>
                                                <AvatarCustom image={dataDialogVariation.items[key].images} variant="square" name={dataDialogVariation.items[key].title} />
                                            </div>
                                        </TableCell>
                                        <TableCell>{dataDialogVariation.items[key].title}</TableCell>
                                        <TableCell>{dataDialogVariation.items[key].sku}</TableCell>
                                        <TableCell>{moneyFormat(dataDialogVariation.items[key].price)}</TableCell>
                                        <TableCell>
                                            {
                                                getQuantityVariation(dataDialogVariation.items[key]).title
                                            }
                                        </TableCell>
                                        <TableCell>
                                            {
                                                getQuantityVariation(dataDialogVariation.items[key]).allow_order ?
                                                    dataDialogVariation.items[key].isSelect ?
                                                        <Button onClick={handleSelectedVariation(key, false)} variant="contained" color="secondary" >
                                                            {__('Cancel')}
                                                        </Button>
                                                        :
                                                        <Button onClick={handleSelectedVariation(key, true)} variant="contained" color="default" >
                                                            choose
                                                        </Button>
                                                    :
                                                    <></>
                                            }
                                        </TableCell>
                                    </TableRow>
                                    :
                                    <React.Fragment key={key}></React.Fragment>
                            ))
                        }
                    </TableBody>
                </Table>
            </DrawerCustom>
            {ajaxAddVariable.Loading}
        </>
    )
}

export default ChooseProduct
