import { Box, Chip, IconButton, makeStyles, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Typography } from '@material-ui/core';
import ClearRoundedIcon from '@material-ui/icons/ClearRounded';
import { Divider, FieldForm } from 'components';
import { moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';
import React from 'react';
import { calculateItemsSubtotal } from './ChooseProduct';


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

export function calculateDiscount(products, discounts) {
    let total = 0;
    discounts.forEach(item => {
        total += item.discount_type === '%' ?
            Number((products.total * item.coupon_amount / 100).toFixed(2))
            :
            item.coupon_amount
    });
    return total;
}

function ChooseCoupon(props) {

    const classes = useStyles();

    const { post, name } = props;

    const [coupons, setCoupons] = React.useState({ total: 0, items: [] });
    const [products, setProducts] = React.useState({ total: 0, items: [] });

    const validateCoupon = (coupon) => {

        let createdAtOrder = post.date_created ? new Date(post.date_created) : new Date();

        if (coupon.expiry_date && createdAtOrder > new Date(coupon.expiry_date)) {
            return false;
        }

        if (coupon.start_date && createdAtOrder < new Date(coupon.start_date)) {
            return false;
        }

        return true;
    };

    React.useEffect(() => {
        let valueInital = { total: 0, items: [] };
        try {
            if (post[name] && typeof post[name] === 'object') {
                valueInital = post[name];
            } else {
                if (post[name]) {
                    valueInital = JSON.parse(post[name]);
                }
            }
        } catch (error) {
            valueInital = { total: 0, items: [] };
        }

        setCoupons(valueInital);

    }, [post.coupons]);

    React.useEffect(() => {
        let valueInital = { total: 0, items: [] };
        try {
            if (post.products && typeof post.products === 'object') {
                valueInital = post.products;
            } else {
                if (post.products) {
                    valueInital = JSON.parse(post.products);
                }
            }
        } catch (error) {
            valueInital = { total: 0, items: [] };
        }

        setProducts(valueInital);

    }, [post.products]);

    return (
        <>
            <Divider color="dark" style={{ marginBottom: 32 }} />
            {
                coupons.items?.length > 0 &&
                <TableContainer style={{ marginBottom: 8, whiteSpace: 'nowrap' }}>
                    <Table className={classes.table}>
                        <TableHead>
                            <TableRow>
                                <TableCell>
                                    Code
                                </TableCell>
                                <TableCell style={{ whiteSpace: 'nowrap', width: 40 }}>
                                    Amount
                                </TableCell>
                                <TableCell style={{ whiteSpace: 'nowrap', width: 40 }}>
                                    Money
                                </TableCell>
                                <TableCell style={{ width: 40 }}></TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {
                                coupons.items.map((item, index) => (
                                    validateCoupon(item) ?
                                        <TableRow key={index}>
                                            <TableCell>
                                                <Chip label={item.title} />
                                            </TableCell>
                                            <TableCell>
                                                {item.coupon_amount} {item.discount_type}
                                            </TableCell>
                                            <TableCell>
                                                - {
                                                    moneyFormat(
                                                        item.discount_type === '%' ?
                                                            Number((products.total * item.coupon_amount / 100).toFixed(2))
                                                            :
                                                            item.coupon_amount
                                                    )
                                                }
                                            </TableCell>
                                            <TableCell>
                                                <IconButton onClick={() => {
                                                    setCoupons(prev => {

                                                        let value = { ...prev };
                                                        value.items.splice(index, 1);
                                                        value.total = calculateDiscount(products, value.items);

                                                        props.onReview(null, {
                                                            [name]: value,
                                                            ecom_coupon: value.items,
                                                        });
                                                        return value;
                                                    });
                                                }}>
                                                    <ClearRoundedIcon className={classes.removeProductIcon} />
                                                </IconButton>
                                            </TableCell>
                                        </TableRow>
                                        :
                                        <React.Fragment key={index}></React.Fragment>
                                ))
                            }
                            <TableRow>
                                <TableCell></TableCell>
                                <TableCell><Typography variant="h5">Total:</Typography> </TableCell>
                                <TableCell>- {moneyFormat(coupons.total)}</TableCell>
                                <TableCell></TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </TableContainer>
            }
            <FieldForm
                compoment='relationship_manytomany'
                config={{
                    title: 'Add Coupon',
                    object: 'ecom_coupon',
                }}
                post={coupons}
                name="items"
                onReview={(value) => {

                    let items = [];
                    value.forEach((item) => {
                        if (validateCoupon(item)) {
                            items.push(item);
                        }
                    });

                    let couponState = { items: items, total: calculateDiscount(products, items) };

                    props.onReview(null, {
                        [name]: couponState,
                        ecom_coupon: items,
                    });
                    setCoupons(couponState);
                }}
                renderTags={() => null}
                getOptionDisabled={(option) => {
                    if (!validateCoupon(option)) {
                        return true;
                    }
                    return false;
                }}
            />
        </>
    )
}

export default ChooseCoupon
