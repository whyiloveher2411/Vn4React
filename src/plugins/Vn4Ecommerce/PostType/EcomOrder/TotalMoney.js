import { Box, Button, IconButton, InputAdornment, Menu, MenuItem, Typography } from '@material-ui/core';
import { FieldForm, MaterialIcon } from 'components';
import React from 'react';

function TotalMoney(props) {
    const { post, name } = props;

    const [products, setProducts] = React.useState([]);

    const [discount, setDiscount] = React.useState({
        type: '$',
        value: 0
    });

    const [openDiscountForm, setOpenDiscountForm] = React.useState(false);

    React.useEffect(() => {
        let valueInital = [];
        try {
            if (post.ecom_prod && typeof post.ecom_prod === 'object') {
                valueInital = post.ecom_prod;
            } else {
                if (post.ecom_prod) {
                    valueInital = JSON.parse(post.ecom_prod);
                }
            }

            if (!Array.isArray(valueInital)) valueInital = [];
        } catch (error) {
            valueInital = [];
        }

        let valueInitalDiscount = {
            type: '$',
            value: 0
        };


        try {
            if (post.discount && typeof post.discount === 'object') {
                valueInitalDiscount = post.discount;
            } else {
                if (post.discount) {
                    valueInitalDiscount = JSON.parse(post.discount);
                }
            }
        } catch (error) {
            valueInitalDiscount = {
                type: '$',
                value: 0
            };
        }

        if (!valueInitalDiscount.type) valueInitalDiscount.type = '$';

        setDiscount(valueInitalDiscount);
        setProducts(valueInital);

    }, []);

    const [anchorEl, setAnchorEl] = React.useState(null);

    const onChangeDiscountType = (type = discount.type, value = discount.value) => {
        setDiscount(prev => ({
            value: value,
            type: type
        }));
        props.onReview({
            value: value,
            type: type
        }, 'discount');
        setAnchorEl(null);
    }

    const handleApplyDiscount = () => {
        props.onReview({
            value: discount.value,
            type: discount.type
        }, 'discount');
        setOpenDiscountForm(false);
    }

    return (
        <div>
            <Box width={320} display="flex" alignItems="centeer" justifyContent="space-between">
                <Typography align="right" style={{ margin: '16px 0' }} variant="h5">Items Subtotal: </Typography>
                <Typography align="right" style={{ margin: '16px 0' }} variant="h5">${products.reduce((previousValue, item) => previousValue + item.quantity * item.price, 0)}</Typography>

            </Box>
            <Box width={320} display="flex" alignItems="centeer" justifyContent="space-between">
                <Typography align="right" style={{ margin: '16px 0' }} variant="h5">Discount:</Typography>
                {
                    openDiscountForm ?
                        <Box display="flex" justifyContent="flex-end" flexWrap="wrap" gridGap={8}>
                            <FieldForm
                                style={{ marginLeft: 8 }}
                                compoment='number'
                                config={{
                                    title: false,
                                }}
                                endAdornment={<InputAdornment style={{ cursor: 'pointer' }} onClick={(e) => setAnchorEl(e.currentTarget)} position="start">{discount.type}</InputAdornment>}
                                post={discount}
                                name='value'
                                onReview={(value) => setDiscount(prev => ({ ...prev, value: value }))}
                            />
                            <Button onClick={handleApplyDiscount} variant="contained" color="primary">Apply</Button>
                        </Box>
                        :
                        discount.value ?
                            <Typography onClick={() => setOpenDiscountForm(true)} align="right" style={{ textDecoration: 'underline', cursor: 'pointer', margin: '16px 0' }} variant="h5">$
                                {
                                    discount.type === '%' ?
                                        Number((products.reduce((previousValue, item) => previousValue + item.quantity * item.price, 0) * discount.value / 100).toFixed(2)) + ' (' + discount.value + '%)'
                                        :
                                        discount.value
                                }
                            </Typography>
                            :
                            <IconButton onClick={() => setOpenDiscountForm(true)} style={{ marginRight: -8 }}>
                                <MaterialIcon icon="AddRounded" />
                            </IconButton>
                }

            </Box>
            <Box width={320} display="flex" alignItems="centeer" justifyContent="space-between">
                <Typography align="right" style={{ margin: '16px 0' }} variant="h5">Shipping:</Typography>
                <Typography align="right" style={{ margin: '16px 0' }} variant="h5">$0</Typography>
            </Box>
            <Box width={320} display="flex" alignItems="centeer" justifyContent="space-between">
                <Typography align="right" style={{ margin: '16px 0' }} variant="h5">Total:</Typography>
                <Typography align="right" style={{ margin: '16px 0' }} variant="h5">${
                    (() => {
                        let total = products.reduce((previousValue, item) => previousValue + item.quantity * item.price, 0)
                            - (discount.value ? discount.type === '%' ? Number((products.reduce((previousValue, item) => previousValue + item.quantity * item.price, 0) * discount.value / 100).toFixed(2)) : discount.value : 0)

                        if (total > 0) return total;

                        return 0;
                    })()
                }
                </Typography>
            </Box>

            <Menu
                anchorEl={anchorEl}
                open={Boolean(anchorEl)}
                onClose={() => setAnchorEl(null)}
            >
                {
                    ['$', '%'].map(type => (
                        <MenuItem
                            key={type}
                            onClick={() => onChangeDiscountType(type)}
                        >
                            {type}
                        </MenuItem>
                    ))
                }
            </Menu>

        </div >
    )
}

export default TotalMoney
