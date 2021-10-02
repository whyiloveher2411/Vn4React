import { moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';
import React from 'react';
import { calculateTotal } from '../Form/TotalMoney';

function TotalMoney(props) {

    const { post } = props;

    const [products, setProducts] = React.useState({ total: 0, items: [] });

    const [coupons, setCoupons] = React.useState({ total: 0, items: [] });

    const [discount, setDiscount] = React.useState({
        type: '$',
        value: 0
    });

    React.useEffect(() => {

        let valueProducts = [];
        try {
            if (post.products && typeof post.products === 'object') {
                valueProducts = post.products;
            } else {
                if (post.products) {
                    valueProducts = JSON.parse(post.products);
                }
            }

        } catch (error) {
            valueProducts = { total: 0, items: [] };
        }

        let valueDiscount = {
            type: '$',
            value: 0
        };

        try {
            if (post.discount && typeof post.discount === 'object') {
                valueDiscount = post.discount;
            } else {
                if (post.discount) {
                    valueDiscount = JSON.parse(post.discount);
                }
            }
        } catch (error) {
            valueDiscount = {
                type: '$',
                value: 0
            };
        }

        if (!valueDiscount.type) valueDiscount.type = '$';


        let valueCoupons = { total: 0, items: [] };
        try {
            if (post.coupons && typeof post.coupons === 'object') {
                valueCoupons = post.coupons;
            } else {
                if (post.coupons) {
                    valueCoupons = JSON.parse(post.coupons);
                }
            }
        } catch (error) {
            valueCoupons = { total: 0, items: [] };
        }

        setCoupons(valueCoupons);
        setDiscount(valueDiscount);
        setProducts(valueProducts);

    }, []);

    const total = calculateTotal(products, coupons, discount);

    return (
        <div>
            {
                Boolean(products.total !== total) &&
                <>
                    <del style={{ textDecoration: 'line-through', color: 'red' }}>{moneyFormat(products.total)}</del> -
                </>
            }
            <span style={{ color: 'green', fontWeight: 'bold' }}> {moneyFormat(total)}</span>
        </div>
    )
}

export default TotalMoney
